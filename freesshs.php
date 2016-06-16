<html>
<head>
<title>ROOT-URI FREE</title>
</head>
<body style="cursor: default; text-align: center;">

<?php
// THIS IS THE ROMANIAN VERSION OF "ROOT-URI FREE v0.2"
// Requirements: Scan archive, PHP, Apache2, www-data write permission (ex: chown -R www-data /var/www/)
// SIMPLE LOGIN SYSTEM
If(isset($_POST['username']) && isset($_POST['password'])) {
	$user = $_POST['username'];
	$pass = $_POST['password'];
	$scan_status = shell_exec("pgrep ssh"); // USE pgrep ssh for MIX //OR// pgrep <idk> for GOSH
	$scan_type = "MIX"; // SCAN TYPE
	$ip = $_SERVER['REMOTE_ADDR'];
	If($user == "username1" && $pass == "password1" or $user == "username2" && $pass == "password2") { //CREDENTIALS
		echo '<p>You are logged as: <span style="color: purple;">'.$user.'</span></p>';
		echo "Scan status: ";
		If(empty($scan_status)) {
			echo '<span style="color: red;">Offline</span>';
		} else {
			echo '<span style="color: green;">Online</span>';
		}
		echo '<p>Scan Type: '.$scan_type.'</p>';
		echo '<p>Your IP: '.$ip.'</p>';
		echo '<p>Last logins:</p>';
		$output = fopen($user."_ip.log","a+");
		date_default_timezone_set("Europe/Bucharest"); // ROMANIA GMT
		$sendout = $ip." @ ".date("d.m.Y h:i:s A")."\n"; //Write in $user_ip.log
		fwrite($output,$sendout); // Write algorithm
		echo '<textarea rows="10" disabled readonly style="resize: none; width: 350px; text-align: center; cursor: default;">'.file_get_contents($user."_ip.log").'</textarea>';
		echo '<p>More features will be added soon!</p>';
		echo '<br>';
		echo '<form>';
		echo '<input type="submit" value="Logout">';
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
?>

<center><h1>ROOT-URI FREE v0.2</h1>
<p><?php
$data = shell_exec("cat /TestScanner/vuln"); // cat + your directory with vuln
If(empty($data)){
echo "Nu am prins nimic! Inca incerc sa prind... Apasa F5 sa vezi daca am prins ceva!";
} else {
echo '<textarea rows="5" readonly style="resize: none; width: 300px; text-align: center; cursor: default;">'.$data.'</textarea>';
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
