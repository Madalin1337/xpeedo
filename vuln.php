<?php
$data = shell_exec("cat /TestScanner/vuln"); // cat + your directory with vuln
$scaneste = shell_exec("pgrep scaneste");
If (empty($scaneste)) {
	echo '<i class="fa fa-meh-o" style="font-size:60px"></i>';
	echo '<p>Status: <span style="color: red;">Offline</span></p>';
} elseif(empty($data)){
echo '<p>Incerc sa prind...</p>';
echo '<img src="http://i.imgur.com/hMXG7JT.gif" alt="wait_bool" style="width:24px;height:24px;">';
} else {
	echo '<p>Vezi ce am prins mai jos!</p>';
	echo '<center>';
	echo '<textarea rows="8" class="input-sm form-control" readonly style="resize: vertical; width: 500px; text-align: center; cursor: default;">'.$data.'</textarea>';
	echo '</center>';
}
?>
