<html>
<head>
<title>ROOT-URI FREE</title>
</head>
<body style="cursor: default; text-align: center;">

<?php
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
		echo '<textarea rows="10" disabled readonly style="resize: none; width: 350px; text-align: center; cursor: default;">'.file_get_contents($user."_ip.log").'</textarea>';
		echo '<form action="" method="post">';
		echo '<br>';
		echo '<input name="clasa" maxlength="7" placeholder="123.123" type="text">';
		echo '<input type="submit" onclick="AlertF();" name="scaneaza" value="Start">';
		$message = "Scan-ul a inceput! Da click pe logout! Inca sunt probleme tehnice!"; // TEHNICAL ISSUES FOR SHELL_EXEC
		echo "<script type='text/javascript'>function AlertF() {alert('$message');}</script>";
		echo '<input type="submit" name="opreste" value="Stop">';
		echo '<input hidden name="usernamesecret" value="'.$user.'">';
		echo '</form>';
		echo '<p>Scan logs:</p>';
		echo '<textarea rows="10" disabled readonly style="resize: none; width: 350px; text-align: center; cursor: default;">'.file_get_contents("scan_logs.log").'</textarea>';
		echo '<br></br>';
		echo '<form>';
		echo '<input type="submit" value="Logout">';
		echo '</form>';
		die();
	} elseif(empty($user) && empty($pass)){
		echo "You can't sign in with blank fields";
		echo '<br></br>';
		echo '<form>';
		echo '<input type="submit" value="Return to main page">';
		echo '</form>';
		die();
	} elseif(ctype_upper($user) && ctype_upper($pass)) {
		echo "Invalid username or password";
		echo '<br></br>';
		echo '<form>';
		echo '<input type="submit" value="Return to main page">';
		echo '</form>';
		die();
	} else {
		echo "Invalid username or password";
		echo '<br></br>';
		echo '<form>';
		echo '<input type="submit" value="Return to main page">';
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
}
?>

<center><h1>ROOT-URI FREE v0.3</h1>
<p><?php
$data = shell_exec("cat /TestScanner/vuln"); // cat + your directory with vuln
If(empty($data)){
echo "Nu am prins nimic! Inca incerc sa prind... Apasa F5 sa vezi daca am prins ceva!";
} else {
	echo '<p>Vezi ce am prins mai jos!</p>';
	echo '<textarea rows="5" readonly style="resize: none; width: 500px; text-align: center; cursor: default;">'.$data.'</textarea>';
}
?></p></center>
<audio autoplay="" loop="" id="music" preload="auto" src="/music.mp3"></audio><br>
<center>
<button id="mute" type="button">Mute/Unmute Music</button>

<script>
var audio = document.getElementById('music');
document.getElementById('mute').addEventListener('click', function (e)
{
e = e || window.event;
audio.muted = !audio.muted;
e.preventDefault();
}, false);
</script>
</center>

<!-- LOGIN ADMIN -->
<br>
<div style="background-image: url(http://i.imgur.com/iqMfOVc.jpg);margin: auto; width: 50%; border: 1px solid black; border-radius: 25px;">
<br></br><br></br>
<h2 class="login">Admin Panel</h2>
<form action="" method="post">
<p class="login">Username:</p>
<input name="username" type="text">
<p class="login">Password:</p>
<input name="password" type="password"><br></br>
<input type="submit" value="Login">
</form>
<br></br><br></br>
</div>
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
</style>
