<?php
$data = shell_exec("cat /TestScanner/vuln"); // cat + your directory with vuln
$scaneste = shell_exec("pgrep scaneste"); // MAIN PROCESS
$scanestea = shell_exec("pgrep scaneste1"); // FIRST PROCESS <CHECK YOUR go.sh or a script>
$scanesteb = shell_exec("pgrep scaneste2"); // SECOND PROCESS <CHECK YOUR go.sh or a script>
If (empty($scaneste) && empty($data)) {
	echo '<i class="fa fa-meh-o" style="font-size:60px"></i>';
	echo '<p>Status: <span style="color: red;">Offline</span></p>';
} elseif(empty($scaneste) && !empty($data)) {
	echo '<p>Status: <span style="color: red;">Offline</span></p>';
	echo '<p>Vezi ce am prins mai jos!</p>';
	echo '<center>';
	echo '<textarea rows="8" id="vulne" class="rz input-sm form-control" readonly style="resize: vertical; width: 500px; text-align: center; cursor: default;">'.$data.'</textarea>';
	echo '</center>';
	echo '<script>';
	echo 'var textarea = document.getElementById("vulne");';
	echo 'textarea.scrollTop = textarea.scrollHeight;';
	echo '</script>';
} elseif(!empty($scanestea) && empty($data)) {
	echo '<p>Scanez dupa IP-uri...</p>';
	echo '<img src="http://i.imgur.com/hMXG7JT.gif" alt="wait_bool" style="width:24px;height:24px;">';
} elseif(!empty($scanesteb) && empty($data)) {
echo '<p>Incerc sa prind...</p>';
echo '<img src="http://i.imgur.com/hMXG7JT.gif" alt="wait_bool" style="width:24px;height:24px;">';
} else {
	echo '<p>Status: <span style="color: green;">Online</span></p>';
	echo '<p>Vezi ce am prins mai jos!</p>';
	echo '<center>';
	echo '<textarea rows="8" id="vulne" class="rz input-sm form-control" readonly style="resize: vertical; width: 500px; text-align: center; cursor: default;">'.$data.'</textarea>';
	echo '</center>';
	echo '<script>';
	echo 'var textarea = document.getElementById("vulne");';
	echo 'textarea.scrollTop = textarea.scrollHeight;';
	echo '</script>';
}
?>
