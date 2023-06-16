<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'salesfro_mohw');
define('DB_PW', 'VS2*}Ib#A]CL');
define('DB_NAME', 'salesfro_events');
define('DB_LANG', 'utf8');
define('DB_TIMEZONE', 'Taiwan/Taipei');

if(function_exists('date_default_timezone_set')) {
	date_default_timezone_set(DB_TIMEZONE);
} else {
	putenv("TZ=".DB_TIMEZONE); 
}

$name = trim($_GET['name']);
$addr = trim($_GET['addr']);
$tel = trim($_GET['tel']);
$status = "S";

$empty = false;
$result['success'] = false;

if(!$name) {
	$empty = true;
	$result['msg'][] = "姓名不可為空。\n";
}
if(!$addr) {
	$empty = true;
	$result['msg'][] = "郵遞區號及地址不可為空\n";
}
if(!$tel) {
	$empty = true;
	$result['msg'][] = "電話不可為空\n";
}
if($empty !== true) {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
	$mysqli->set_charset(DB_LANG);
	if($mysqli->connect_error) {
		$result['msg'] = "資料庫連結失敗，錯誤訊息：" . $mysqli->connect_error;
	} else {
        $event_name = "MOTC2022event";
		$sql = "insert into sf_events (event_name, full_name_zh, mobile, residential_address) values (?, ?, ?, ?)";
		if($stmt = $mysqli->prepare($sql)) {
			$stmt->bind_param("ssss", $event_name, $name, $tel, $addr);
			$stmt->execute();
			if($stmt->affected_rows) {
				$id = $mysqli->insert_id;
				$result['success'] = true;
			}
		}
		$stmt->close();
		$mysqli->close();
	}
}

echo "result(".json_encode($result).")";

?>
