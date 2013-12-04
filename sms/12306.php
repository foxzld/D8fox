<?php
/**
 *火车票查询方法 简单尝试
 *
 * @copyright			widuu
 * @license				http://www.widuu.com
 * @lastmodify			2013-6-20
 */

function json_array($json){
		if($json){
			foreach ((array)$json as $k=>$v){
				$data[$k] = !is_string($v)? json_array($v):$v;
			}
			return $data;
		}
	}
function doget ($start,$end,$time) // get获取数据使用
	{
		if(empty($time)){
			$time = date('Y-m-d',time());
		}else{
			if(substr($time,0,1)!=0){
				$time = date('Y-0',time()).$time;
				echo substr($time,0,1);
			}else{
				$time = date('Y-',time()).$time;
			}
		}
		$name = include ("../name.php");
		$star = $name[$start];
		$end = $name[$end];
		$url = "http://dynamic.12306.cn/otsquery/query/queryRemanentTicketAction.do?method=queryLeftTicket&orderRequest.train_date={$time}&orderRequest.from_station_telecode={$star}&orderRequest.to_station_telecode={$end}&orderRequest.train_no=&trainPassType=QB&trainClass=QB%23D%23Z%23T%23K%23QT%23&includeStudent=00&seatTypeAndNum=&orderRequest.start_time_str=00%3A00--24%3A00";
		$optionget = array('http' => array('method' => "GET", 'header' => "User-Agent:Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.21022; .NET CLR 3.0.04506; CIBA)\r\nAccept:*/*\r\nReferer:http://dynamic.12306.cn/otsquery/query/queryRemanentTicketAction.do?method=init")); 
		$file = file_get_contents($url, false , stream_context_create($optionget));
		return json_array(json_decode($file));
	}
	$result = doget("北京","廊坊","6-23");
  	$result = strip_tags($result['datas']);
	$return_str = str_replace("&nbsp;","",$result);
	$return_str = str_replace("\\n","",$return_str);
	$a = explode(",",$return_str);
	$name =array();
	$c = array_chunk($a,16);
	array_pop($c);
	foreach($c as $k =>$v){
		$str="余票：<br>商务座:".$v[5]."，特等座:".$v[6]."，一等座:".$v[7]."，二等座:".$v[8]."，高级软卧:".$v[9]."，软卧:".$v[10]."，硬卧:".$v[11]."，软座:".$v[12]."，硬座:".$v[13]."，无座:".$v[14]."，其他:".$v[15];
		$str = preg_replace("/，硬座\:--，/","",$str);
		$str = preg_replace("/商务座\:--，/","",$str);
		$str = preg_replace("/，特等座\:--，/","",$str);
		$str = preg_replace("/，一等座\:--，/","",$str);
		$str = preg_replace("/，二等座\:--，/","",$str);
		$str = preg_replace("/，高级软卧\:--，/","",$str);
		$str = preg_replace("/，软卧\:--，/","",$str);
		$str = preg_replace("/，硬卧\:--，/","",$str);
		$str = preg_replace("/，软座\:--，/","",$str);
		$str = preg_replace("/，硬座\:--，/","",$str);
		$str = preg_replace("/，其他\:--/","",$str);
		echo "车次:{$v[1]},发站：{$v[2]}，到站：{$v[3]}，历时：{$v[4]}，<br>{$str}<br>";
	}