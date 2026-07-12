<?php
$env = parse_ini_file('.env');

try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_NAME']}",
        $env['DB_USER'],
        $env['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS visits (id INT AUTO_INCREMENT PRIMARY KEY, visited_at DATETIME)");
    $pdo->exec("INSERT INTO visits (visited_at) VALUES (NOW())");
    $count = $pdo->query("SELECT COUNT(*) FROM visits")->fetchColumn();

    echo "<h1>Connected to database: {$env['DB_NAME']}</h1>";
    echo "<p>This page has been visited $count times.</p>";
} catch (PDOException $e) {
    echo "<h1>Database connection failed</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
