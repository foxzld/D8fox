<?php

define( 'BNC_API_VERSION', '3.2' );
define( 'BNC_API_URL', '' . BNC_API_VERSION );
define( 'BNC_API_TIMEOUT', 20 );

class BNCAPI {
	var $bncid;
	var $license_key;
	var $time_variance;
	var $credentials_invalid;
	var $server_down;
	var $response_code;
	var $server_nonce;
	var $attempts;

	function BNCAPI( $bncid, $license_key ) {
		$this->bncid = $bncid;
		$this->license_key = $license_key;
		$this->credentials_invalid = false;
		$this->server_down = false;
		$this->response_code = 0;
		$this->server_nonce = false;
		$this->attempts = 0;
	}

	function do_api_request( $method, $command, $params = array(), $do_auth = false ) {
		$url = BNC_API_URL . "/{$method}/{$command}/";

		// Always use the PHP serialization method for data
		$params[ 'format' ] = 'php';

		if ( !$this->bncid || !$this->license_key ) {
			return false;
		}

		if ( $do_auth ) {
			// Get the nonce
			if ( !$this->server_nonce ) {
				$bnc_settings = wptouch_get_settings( 'bncid' );

				$fetch_server = true;
				if ( isset( $bnc_settings->nonce ) ) {
					if ( time() < $bnc_settings->nonce->valid_until ) {
						$fetch_server = false;

						$this->server_nonce = $bnc_settings->nonce->nonce;
					}
				}

				if ( $fetch_server ) {
					$current_nonce = $this->get_authentication_nonce();
					$bnc_settings->nonce = $current_nonce;
					$bnc_settings->save();

					$this->server_nonce = $current_nonce->nonce;
				}
			}

			if ( !$this->server_nonce ) {
				// This was an error
				if ( $this->get_response_code() == 408 ) {
					// Unknown user
					$this->credentials_invalid = true;
				}

				return false;
			}

			// Add the timestamp into the request, offseting it by the difference between this server's time and the BNC server's time
			$params[ 'timestamp' ] = time() + $this->time_variance;

			// Sort the parameters
			ksort( $params );

			// Generate a string to use for authorization
			$auth_string = '';
			foreach( $params as $key => $value ) {
				$auth_string = $auth_string . $key . $value;
			}

			WPTOUCH_DEBUG( WPTOUCH_WARNING, 'Auth string [' . $auth_string . '], Nonce [' . $this->server_nonce . '], Key [' . $this->license_key . ']' );

			// Create the authorization hash using the server nonce and the license key
			$params[ 'auth' ] = md5( $auth_string . $this->server_nonce . $this->license_key );
		}

        $body_params = array();
        foreach( $params as $key => $value ) {
        	$body_params[] = $key . '=' . urlencode( $value );
        }
        $body = implode( '&', $body_params );

        $options = array( 'method' => 'POST', 'timeout' => BNC_API_TIMEOUT, 'body' => $body );
        $options['headers'] = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=' . get_option('blog_charset'),
            'Content-Length' => strlen( $body ),
            'User-Agent' => 'WordPress/' . get_bloginfo("version") . '/WPtouch-Pro',
            'Referer' => get_bloginfo("url")
        );

        $this->attempts++;
        $raw_response = wp_remote_request( $url, $options );
        if ( !is_wp_error( $raw_response ) ) {

        	if ( $raw_response['response']['code'] == 200 ) {
        		$result = unserialize( $raw_response['body'] );

        		$this->response_code = $result['code'];
        		return $result;
        	} else {
        		WPTOUCH_DEBUG( WPTOUCH_WARNING, "Unable to connect to server. Response code is " . $raw_response[ 'response' ][ 'code' ] );
        		return false;
        	}
        } else {
       		$this->server_down = true;
       		return false;
        }
	}

	function get_response_code() {
		return $this->response_code;
	}

	function get_proper_server_name() {
		$server_name = $_SERVER['HTTP_HOST'];
		if ( strpos( $server_name, ':' ) !== false ) {
			$server_params = explode( ':', $server_name );

			return $server_params[0];
		} else {
			return $server_name;
		}
	}

	function verify_site_license( $product_name ) {
		$params = array(
			'bncid' => $this->bncid,
			'site' => $this->get_proper_server_name(),
			'product_name' => $product_name
		);

		$result = $this->do_api_request( 'user', 'verify_license', $params, true );

		if ( $result and $result['status'] == 'ok' ) {
			return true;
		}

		return false;
	}

	function get_total_licenses( $product_name ) {
		$params = array(
			'bncid' => $this->bncid,
			'product_name' => $product_name
		);

		$result = $this->do_api_request( 'user', 'get_license_count', $params, true );
		if ( $result and $result['status'] == 'ok' ) {
			return $result['result']['count'];
		}

		return false;
	}

	function get_product_version( $product_name ) {
		$params = array(
			'bncid' => $this->bncid,
			'site' => $this->get_proper_server_name(),
			'product_name' => $product_name
		);

		$result = $this->do_api_request( 'products', 'get_version', $params, true );
		if ( $result and $result['status'] == 'ok' ) {
			return $result['result']['product'];
		}

		return false;
	}

	function user_list_licenses( $product_name ) {
		$params = array(
			'bncid' => $this->bncid,
			'product_name' => $product_name
		);

		$result = $this->do_api_request( 'user', 'list_licenses', $params, true );
		if ( $result and $result['status'] == 'ok' ) {
			return $result['result'];
		}

		return false;
	}

	function user_add_license( $product_name ) {
		$params = array(
			'bncid' => $this->bncid,
			'product_name' => $product_name,
			'site' => $this->get_proper_server_name()
		);

		$result = $this->do_api_request( 'user', 'add_license', $params, true );
		if ( $result and $result['status'] == 'ok' ) {
			return true;
		}

		return false;
	}

	function get_authentication_nonce() {
		$params = array();
		$params['bncid'] = $this->bncid;

		$result = $this->do_api_request( 'auth', 'get_nonce', $params );
		if ( $result ) {
			if ( $result['status'] == 'ok' ) {
				$nonce_result = new stdClass;
				$nonce_result->nonce = $result['result']['nonce'];
				$nonce_result->valid_until = $result['result']['nonce_valid_until'];

				return $nonce_result;
			} else if ( $result['code'] == 408 ) {
				// unknown user
				$this->credentials_invalid = true;
			}
		}

		return false;
	}
}
