<!DOCTYPE html>
<html>
<head><title>Show My IP</title></head>
<body>
<button onclick="showIp()">Show my IP</button>
<div id="ip" style="display:none">
    <p>IPv4: <span id="ipv4">unavailable</span></p>
    <p>IPv6: <span id="ipv6">unavailable</span></p>
</div>

<script>
async function fetchIp(url) {
    try {
        const res = await fetch(url);
        const data = await res.json();
        return data.ip;
    } catch (e) {
        return null;
    }
}

async function showIp() {
    const [ipv4, ipv6] = await Promise.all([
        fetchIp('https://api.ipify.org?format=json'),
        fetchIp('https://api6.ipify.org?format=json')
    ]);

    document.getElementById('ipv4').textContent = ipv4 || 'unavailable';
    document.getElementById('ipv6').textContent = (ipv6 && ipv6 !== ipv4) ? ipv6 : 'unavailable';
    document.getElementById('ip').style.display = 'block';

    fetch('save_ip.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ipv4, ipv6: (ipv6 && ipv6 !== ipv4) ? ipv6 : null })
    });
}
</script>
</body>
</html>
