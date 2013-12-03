<?php

function wptouch_admin_handle_ajax( $wptouch_pro, $ajax_action ) {
	switch( $ajax_action ) {
		case 'delete-theme':
			$delete_src = WP_CONTENT_DIR . $wptouch_pro->post[ 'location' ];

			$wptouch_pro->recursive_delete( $delete_src );
			@rmdir( $delete_src );

			break;
		case 'dismiss-warning':
			$wptouch_pro->check_plugins_for_warnings();
			$settings = $wptouch_pro->get_settings();
			if ( $wptouch_pro->post['plugin'] ) {
				if ( !in_array( $wptouch_pro->post['plugin'], $settings->dismissed_warnings ) ) {
					$settings->dismissed_warnings[] = $wptouch_pro->post['plugin'];

					$settings->save();
				}
			}

			echo wptouch_get_plugin_warning_count();

			break;
		case 'reset-all-licenses':
			if ( $wptouch_pro->bnc_api->reset_all_licenses( 'wptouch-pro' ) ) {
				echo 'ok';
			} else {
				echo 'fail';
			}
			break;
		case 'activate-license-key':
			$email = $wptouch_pro->post['email'];
			$key = $wptouch_pro->post['key'];

			$settings = wptouch_get_settings( 'bncid' );

			$settings->bncid = $email;
			$settings->wptouch_license_key = $key;

			WPTOUCH_DEBUG( WPTOUCH_INFO, "Attempting site activation with email [" . $email . "] and key [" . $key . "]" );

			$settings->save();

			$wptouch_pro->bnc_api->bncid = $email;
			$wptouch_pro->bnc_api->license_key = $key;

			// let's try to activate the license
			$wptouch_pro->activate_license();

			// Check to see if the credentials were valid
			if ( $wptouch_pro->bnc_api->response_code >= 406 && $wptouch_pro->bnc_api->response_code <= 408 ) {
				WPTOUCH_DEBUG( WPTOUCH_WARNING, "Activation response code was [" . $wptouch_pro->bnc_api->response_code . "]" );
				echo '2';
			} else if ( $wptouch_pro->bnc_api->server_down ) {
				// Server is unreachable for some reason
				WPTOUCH_DEBUG( WPTOUCH_WARNING, "Activation response code was [SERVER UNREACHABLE]" );
				echo '4';
			} else if ( $wptouch_pro->bnc_api->verify_site_license( WPTOUCH_PRO_BNCAPI_PRODUCT_NAME ) ) {
				// Activation successful
				WPTOUCH_DEBUG( WPTOUCH_WARNING, "Activation successful, response code was [" . $wptouch_pro->bnc_api->response_code . "]" );

				$settings = wptouch_get_settings();

				$settings->license_accepted = true;
				$settings->license_accepted_time = time();

				// add info for multisite
				if ( wptouch_is_multisite_enabled() && function_exists( 'update_site_option' ) ) {
					update_site_option( WPTOUCH_MULTISITE_LICENSED, 1 );
				}

				$settings->save();

				echo '1';
			} else {
				// No more licenses - might be triggered another way
				WPTOUCH_DEBUG( WPTOUCH_WARNING, "Failure: activation response code was [" . $wptouch_pro->bnc_api->response_code . "]" );
				echo '3';
			}
			break;
		case 'enable-menu-item':
			if ( isset( $wptouch_pro->post[ 'is_checked' ] ) && isset( $wptouch_pro->post[ 'page_id' ] ) ) {
				$page_id = $wptouch_pro->post[ 'page_id' ];

				// save the icon state
				if ( $wptouch_pro->post[ 'is_checked' ] ) {
					delete_post_meta( $page_id, '_wptouch_pro_menu_item_disabled' );
				} else {
					update_post_meta( $page_id, '_wptouch_pro_menu_item_disabled', '1' );
				}

				echo '0';
			}
			break;
		case 'update-page-icon':
			if ( isset( $wptouch_pro->post[ 'page_id'] ) && isset( $wptouch_pro->post[ 'image_file' ] ) ) {
				$page_id = $wptouch_pro->post[ 'page_id' ];
				$image_file = str_replace( wptouch_check_url_ssl( site_url() ), '', $wptouch_pro->post[ 'image_file' ] );

				// save the icon state
				update_post_meta( $page_id, '_wptouch_pro_menu_item_icon', $image_file );

				echo '0';
			}

			break;
		case 'reset-page-icons-and-state':
			$wptouch_pro->reset_icon_states();
			echo '0';
			break;
		case 'set-default-icon':
			$settings = wptouch_get_settings();
			$settings->default_menu_icon = str_replace( wptouch_check_url_ssl( site_url() ), '', $wptouch_pro->post[ 'image_file' ] );
			$settings->save();

			echo '0';
			break;
		case 'reset-page-icon':
			if ( isset( $wptouch_pro->post[ 'page_id' ] ) ) {
				delete_post_meta( $wptouch_pro->post[ 'page_id' ], '_wptouch_pro_menu_item_icon' );
				echo '0';
			}
			break;
		case 'delete-image-upload':
			if ( isset( $wptouch_pro->post[ 'setting_name' ] ) ) {
				$wptouch_pro->update_encoded_setting( $wptouch_pro->post[ 'setting_name'], false );
				echo '0';
			}
			break;
		case 'delete-custom-icon':
			if ( current_user_can( 'upload_files' ) ) {
				if ( isset( $wptouch_pro->post[ 'icon_name' ] ) ) {
					$icon_location = WPTOUCH_CUSTOM_ICON_DIRECTORY . '/' . $wptouch_pro->post[ 'icon_name' ];

					unlink( $icon_location );
					echo '0';
				}
			}

			break;
		case 'load-news':
			echo wptouch_capture_include_file( WPTOUCH_DIR . '/admin/html/news.php' );
			break;
		case 'load-notifications':
			wptouch_notification_setup();

			$result = array();
			$result[ 'html' ] = wptouch_capture_include_file( WPTOUCH_DIR . '/admin/html/notification-content.php' );
			$result[ 'count' ] = wptouch_get_notification_count();

			echo json_encode( $result );
			break;
		case 'dismiss-notification':
			wptouch_notification_setup();

			$settings = wptouch_get_settings();

			if ( !in_array( $wptouch_pro->post[ 'notification_key' ], $settings->dismissed_notifications ) ) {
				$settings->dismissed_notifications[] = $wptouch_pro->post[ 'notification_key' ];
				$settings->save();
			}

			$result = array();
			$result[ 'html' ] = wptouch_capture_include_file( WPTOUCH_DIR . '/admin/html/notification-content.php' );
			$result[ 'count' ] = wptouch_get_notification_count();

			echo json_encode( $result );
			break;
		case 'load-plugin-compat-list':
			$wptouch_pro->generate_plugin_hook_list( true );

			$compat_settings = wptouch_get_settings( 'compat' );
			if ( is_array( $compat_settings->plugin_hooks ) && count( $compat_settings->plugin_hooks ) ) {
				$changed = false;
				foreach( $compat_settings->plugin_hooks as $name => $value ) {
					if ( !isset( $compat_settings->enabled_plugins[ $name ] ) ) {
						$compat_settings->enabled_plugins[ $name ] = 1;
						$changed = true;
					}
				}

				if ( $changed ) {
					$compat_settings->save();
				}
			}

			echo wptouch_capture_include_file( WPTOUCH_DIR . '/admin/settings/custom/html/plugin-compat-ajax.php' );
			break;
		case 'prep-settings-download':
			require_once( WPTOUCH_DIR . '/core/admin-backup-restore.php' );
			$backup_file = wptouch_backup_settings();

			echo $backup_file;
			break;
		case 'touchboard-images':
			$response = wp_remote_get( 'http://wptouch-pro-3.s3.amazonaws.com/WPtouchBoard/config.txt' );
			if ( !is_wp_error( $response ) ) {
				$images = array();

				if ( isset( $response[ 'body' ] ) ) {
					$image_files = explode( "\n", $response[ 'body' ] );

					foreach( $image_files as $image ) {
						$images[] = 'http://wptouch-pro-3.s3.amazonaws.com/WPtouchBoard/' . trim( $image );
					}

					echo json_encode( $images );
				}
			}
			break;
		case 'download-icon-set':
			global $wptouch_pro;

			require_once( WPTOUCH_DIR . '/core/icon-set-installer.php' );

			$icon_set_installer = new WPtouchIconSetInstaller;
			$icon_set_installer->install( $wptouch_pro->post[ 'base' ] , $wptouch_pro->post[ 'url' ] );

			if ( file_exists( WPTOUCH_BASE_CONTENT_DIR . '/icons/' . $wptouch_pro->post[ 'base' ] ) ) {
				echo '1';
			} else {
				echo '0';
			}

			break;
		case 'get-icon-set-info':
			require_once( WPTOUCH_DIR . '/core/admin-icons.php' );

			echo wptouch_capture_include_file( WPTOUCH_DIR . '/admin/settings/custom/html/installed_icon_sets_ajax.php' );
			break;
		case 'admin-change-log':
			$change_log = wp_remote_get( WPTOUCH_PRO_README_FILE );
			if ( !is_wp_error( $change_log ) ) {

				$content = $change_log[ 'body' ];

				$result = preg_match_all( "# Version (.*) =(.*)\n=#iUs", $content, $matches );

				if ( $result ) {
					$entries = count( $matches[0] );

					for ( $i = 0; $i < $entries; $i++) {
						echo '<h4 style="font-family: Helvetica, sans-serif">' . sprintf( __( 'Version %s', 'wptouch-pro' ), $matches[1][$i] ) . '</h4><ul  style="font-family: Helvetica, sans-serif; font-size: 13px">';
						echo str_replace( '* ', '<li style="padding-top:3px;padding-bottom:3px;">', str_replace( "\n", "</li>\n", $matches[2][$i] ) );
						echo '</ul>';
					}
				}
			} else {
				echo __( 'There is a temporary issue retrieving the change-log.  Please try again later.', 'wptouch-pro' );
			}
			break;
		default:
			do_action( 'wptouch_admin_ajax_' . $ajax_action );
			break;
	}
}
