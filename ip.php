<!DOCTYPE html>
<html>
<head>
<title>Show My IP</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #667eea, #764ba2);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }
    .card {
        background: #fff;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    button {
        background: #764ba2;
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    button:hover {
        background: #667eea;
    }
    #ip {
        margin-top: 1.5rem;
    }
    #ip p {
        font-size: 1.1rem;
        margin: 0.5rem 0;
    }
    #ip span {
        font-weight: bold;
        color: #764ba2;
    }
</style>
</head>
<body>
<div class="card">
    <button onclick="showIp()">Show my IP</button>
    <div id="ip" style="display:none">
        <p>IPv4: <span id="ipv4">unavailable</span></p>
        <p>IPv6: <span id="ipv6">unavailable</span></p>
    </div>
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
