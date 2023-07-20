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

$pass = trim($_POST['pass']);
if(!$pass) {
	$empty = true;
}


if($empty !== true && $pass == '0910308501') {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
	$mysqli->set_charset(DB_LANG);
	if($mysqli->connect_error) {
		$result = "資料庫連結失敗，錯誤訊息：" . $mysqli->connect_error;
	} else {
        $event_name = "baphiq2023event";
		$sql = "select full_name_zh, mobile, email, created_at from sf_events where event_name=?";
		if($stmt = $mysqli->prepare($sql)) {
			$stmt->bind_param("s", $event_name);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$result = "<table width='750' border='1' cellspacing='0'><tr><td height='30' colspan='5' align='center'>防檢局動植物檢疫守門員培訓計畫名單</td></tr><tr><td width='50' height='30' align='center'>序號</td><td width='150' height='30' align='center'>姓名</td><td width='150' height='30' align='center'>電話</td><td width='150' height='30' align='center'>EMAIL</td><td width='250' height='30' align='center'>建立時間</td></tr>";
			$i = 0;
			foreach($data as $row) {
				$result .= "<tr><td height='30' align='center'>" . (++$i) . "</td><td height='30' align='center'>" . $row['full_name_zh'] . "</td><td height='30' align='center'>" . $row['mobile'] . "</td><td height='30' align='center'>" . $row['email'] . "</td><td height='30' align='center'>" . $row['created_at'] . "</td></tr>";
			}
			$result .= "</table>";
		}
		$stmt->close();
		$mysqli->close();
	}
	echo $result;
} else {
?>
<form id="form" method="post" action="result.php">
  請輸入密碼：<input type="password" id="pass" name="pass">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="送出" />
</form>
<?
}


?>
