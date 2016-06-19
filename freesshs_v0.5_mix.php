<html>
<head>
<title>ROOT-URI FREE</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
</head>
<body style="cursor: default; text-align: center; font-family: 'Ubuntu', sans-serif;">

<?php
// SPECIAL THANKS TO: XPEEDO
// SIMPLE LOGIN SYSTEM
	If(isset($_POST['username']) && isset($_POST['password'])) {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$scan_status1 = shell_exec("pgrep scaneste"); // Type cat a or cat go.sh and rename scripts such as "ss, ssh, ssh-scan, pscan2, etc." in a wierd name like "scaneste" followed by a number such as "scaneste1, scaneste2". Also edit names in script and rename scripts
		$scan_type = "MIX"; // SCAN TYPE
		$ip = $_SERVER['REMOTE_ADDR']; // GET IP LOG
		If($user == "test" && $pass == "test") { //CREDENTIALS
		//
		$output = fopen($user."_ip.log","a+"); // OPEN FILE
		date_default_timezone_set("Europe/Bucharest"); // ROMANIA GMT
		$sendout = $ip." @ ".date("d.m.Y h:i:s A")."\n"; //Write in $user_ip.log
		fwrite($output,$sendout); // Write algorithm [TO ADD WRITE PERMISSION TYPE IN SSH CONSOLE: chown -R apache /your/www/path //OR// chown -R www-data /your/www/path]
		//
		echo '<p>You are logged as: <span style="color: purple;">'.$user.'</span></p>';
		echo "Scan status: ";
		If(empty($scan_status1)) { //if script is not found in top or taskmanager
			echo '<span style="color: red;">Offline</span>';
		} else {
			echo '<span style="color: green;">Online</span>';
		}
		echo '<p>Scan Type: '.$scan_type.'</p>';
		echo '<p>Your IP: '.$ip.'</p>';
		echo '<p>Last logins:</p>';
		echo '<div align="center" class="form-group">';
		echo '<textarea rows="9" class="input-sm form-control" disabled readonly style="resize: none; width: 325px; text-align: center; cursor: default;">'.file_get_contents($user."_ip.log").'</textarea>';
		echo '</div>';
		echo '<form action="" method="post">';
		echo '<div align="center" class="form-group">';
		echo '<input class="input-sm form-control" name="clasa" style="width: 10%; text-align: center;" maxlength="7" placeholder="123.123" type="text">';
		echo '</div>';
		echo '<input class="btn btn-sm btn-default" type="submit" onclick="AlertF();" name="scaneaza" value="Start">';
		$message = "Scan-ul a inceput! Da click pe logout! Inca sunt probleme tehnice!"; // TEHNICAL ISSUES FOR SHELL_EXEC
		echo "<script type='text/javascript'>function AlertF() {alert('$message');}</script>";
		echo '<input class="btn btn-sm btn-default" type="submit" name="opreste" value="Stop">';
		echo '<input hidden name="usernamesecret" value="'.$user.'">';
		echo '</form>';
		echo '<p>Scan logs:</p>';
		echo '<div align="center" class="form-group">';
		echo '<textarea class="input-sm form-control" rows="9" disabled readonly style="resize: none; width: 325px; text-align: center; cursor: default;">'.file_get_contents("scan_logs.log").'</textarea>';
		echo '</div>';
		echo '<form action="" method="post">';
		echo 'Clear: ';
		echo '<input class="btn btn-sm btn-default" type="submit" name="clearvuln" value="Vuln">';
		echo '<input class="btn btn-sm btn-default" type="submit" name="clearscan" value="Scan logs">';
		echo '<input class="btn btn-sm btn-default" type="submit" name="clearlogins" value="My last logins">';
		echo '<input hidden name="usernamesecreto" value="'.$user.'">';
		echo '</form>';
		echo '<form>';
		echo '<input class="btn btn-sm btn-default" type="submit" value="Logout">';
		echo '</form>';
		die();
	} elseif(empty($user) && empty($pass)){
		echo "You can't sign in with blank fields";
		echo '<br></br>';
		echo '<form>';
		echo '<input class="btn btn-sm btn-default" type="submit" value="Return to main page">';
		echo '</form>';
		die();
	} elseif(ctype_upper($user) && ctype_upper($pass)) {
		echo "Invalid username or password";
		echo '<br></br>';
		echo '<form>';
		echo '<input class="btn btn-sm btn-default" type="submit" value="Return to main page">';
		echo '</form>';
		die();
	} else {
		echo "Invalid username or password";
		echo '<br></br>';
		echo '<form>';
		echo '<input class="btn btn-sm btn-default" type="submit" value="Return to main page">';
		echo '</form>';
		die();
	}
}

/* SIMPLE SCAN SYSTEM
HOW TO CONFIG IT:
1. EDIT IN /etc/sudoers:
1.1: Add "#" to this:
#Defaults    requiretty
If you don't find it skip this step.
1.2: Add this at the end:
apache ALL=(ALL) NOPASSWD: ALL
or
www-data ALL=(ALL) NOPASSWD: ALL

If you're not sure what is your username type cat /etc/passwd and find www-data or apache.
*/
elseif(isset($_POST['clasa']) && isset($_POST['scaneaza']) && isset($_POST['usernamesecret'])) { // SENDING SCAN
	$clasa = $_POST['clasa'];
	$scaneaza = $_POST['scaneaza'];
	$scannestee = shell_exec("pgrep scaneste");
	$ip1 = $_SERVER['REMOTE_ADDR'];
	$user1 = $_POST['usernamesecret'];
	If($clasa == "") {
		echo "Clasa invalida sau necompletata!";
	} elseif(!empty($scannestee)) {
		echo "Este deja un scan in desfasurare!";
	} else {
		echo "Scan inceput cu succes!";
		$scanlog1 = fopen("scan_logs.log","a+"); // OPEN FILE
		date_default_timezone_set("Europe/Bucharest"); // ROMANIA GMT
		$sendscanlogstart = "Scan pornit de: ".$user1."\nPe clasa: ".$clasa."\nData & Ora: ".date("d.m.Y h:i:s A")."\nIP: ".$ip1."\n=========================================\n";
		fwrite($scanlog1,$sendscanlogstart);
		shell_exec("cd /TestScanner && sudo ./a ".$clasa." > /dev/null &");
	}
} elseif(isset($_POST['opreste']) && isset($_POST['usernamesecret'])) {
	$opreste = $_POST['opreste'];
	$scanneste = shell_exec("pgrep scaneste");
	$ip2 = $_SERVER['REMOTE_ADDR'];
	$user2 = $_POST['usernamesecret'];
	If(!empty($scanneste)) {
		$scanlog2 = fopen("scan_logs.log","a+"); // OPEN FILE
		date_default_timezone_set("Europe/Bucharest"); // ROMANIA GMT
		$sendscanlogstop = "Scan oprit de: ".$user2."\nData & Ora: ".date("d.m.Y h:i:s A")."\nIP: ".$ip2."\n=========================================\n";
		fwrite($scanlog2,$sendscanlogstop);
		shell_exec("sudo pkill scaneste"); // BRUTE EXIT \ You need to kill scanning first after
		shell_exec("sudo pkill scaneste"); // BRUTE EXIT / kill bruteforce, and that's it!
		echo "Scan-ul a fost oprit cu succes!";
	} else {
		echo "Scan-ul nu este pornit!";
	}
} elseif(isset($_POST['clearvuln']) && isset($_POST['usernamesecreto'])) { // CLEAR VULN
	$usero = $_POST['usernamesecreto'];
	If($usero == "xpeedo") { // ALLOWED USER
		shell_exec("sudo rm -rf /TestScanner/vuln");
		shell_exec("sudo touch /TestScanner/vuln");
		echo "Vuln-ul a fost sters!";
	} else { // DENIED USERS
		echo "Nu ai permisiune sa stergi vuln-ul!";
	}
} elseif(isset($_POST['clearscan']) && isset($_POST['usernamesecreto'])) {
	$useroo = $_POST['usernamesecreto'];
	If($useroo == "xpeedo") { // SAME
		shell_exec("sudo rm -rf /var/www/html/scan_logs.log");
		echo "Scan log-ul a fost sters!";
	} else { // SAME
		echo "Nu ai permisiune sa stergi scan log-ul!";
	}
} elseif(isset($_POST['clearlogins']) && isset($_POST['usernamesecreto'])) { // CLEAR LAST LOGIN FOR A SPECIFIC USER! ALL USERS ARE ALLOWED!
	$userooo = $_POST['usernamesecreto'];
	shell_exec("sudo rm -rf /var/www/html/".$userooo."_ip.log");
	echo "Ultimele tale login-uri au fost sterse cu succes!";
}
?>

<h1>ROOT-URI FREE v0.5</h1>
<div class="form-group" id="vuln"></div><br>
<button onclick="update()" class="btn btn-sm btn-default" type="button">Update</button>
<script>
window.onload = $("#vuln").load("vuln.php");
function loadNowPlaying(){
  $("#vuln").load("vuln.php");
}
setInterval(function(){loadNowPlaying()}, 5000);
function update() {
	$("#vuln").load("vuln.php");
}
</script><br>

<!-- LOGIN ADMIN -->
<br>
<div style="background-image: url(http://i.imgur.com/iqMfOVc.jpg);margin: auto; width: 50%; border: 1px solid black; border-radius: 25px;">
<br></br>
<h3 class="login">Admin Panel</h3>
<form action="" method="post">
<div align="center" class="form-group">
<label for="usr" class="login">Username:</label>
<input id="usr" style="width: 50%; text-align: center;" placeholder="username" class="input-sm form-control" name="username" type="text">
</div>
<div align="center" class="form-group">
<label for="pwd" class="login">Password:</label>
<input id="pwd" class="input-sm form-control" style="width: 50%; text-align: center;" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" name="password" type="password">
</div><br></br>
<input class="btn btn-sm btn-default" type="submit" value="Login">
</form>
<br></br>
</div><br>
<button id="mute" class="btn btn-sm btn-default" type="button">Mute/Unmute Music</button><br>
<audio autoplay="" loop="" id="music" preload="auto" src="/music.mp3"></audio>
<script>
var audio = document.getElementById('music');
document.getElementById('mute').addEventListener('click', function (e)
{
e = e || window.event;
audio.muted = !audio.muted;
e.preventDefault();
}, false);
</script>
<!-- LOGIN ADMIN -->
<br>
<sub>Coded by Xpeedo &copy; 2016</sub>
</body>
</html>
<style>
.login {
	color: white;
	font-weight: bold;
}
a, a:active, a:focus{
	outline: none;
    }
.btn:focus,.btn:active {
   outline: none !important;
}
</style>
