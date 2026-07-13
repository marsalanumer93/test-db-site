<?php
header('Content-Type: application/json');

$env = parse_ini_file('.env');
$input = json_decode(file_get_contents('php://input'), true) ?? [];

$ipv4 = $input['ipv4'] ?? null;
$ipv6 = $input['ipv6'] ?? null;

try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_NAME']}",
        $env['DB_USER'],
        $env['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS ip_visits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ipv4 VARCHAR(45),
        ipv6 VARCHAR(45),
        visited_at DATETIME
    )");

    $stmt = $pdo->prepare("INSERT INTO ip_visits (ipv4, ipv6, visited_at) VALUES (?, ?, NOW())");
    $stmt->execute([$ipv4, $ipv6]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
