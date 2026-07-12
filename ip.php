<?php
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ip = htmlspecialchars(explode(',', $ip)[0]);
?>
<!DOCTYPE html>
<html>
<head><title>Show My IP</title></head>
<body>
<button onclick="document.getElementById('ip').style.display='block'">Show my IP</button>
<div id="ip" style="display:none">Your IP address is: <?php echo $ip; ?></div>
</body>
</html>
