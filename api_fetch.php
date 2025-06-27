<?php
// API endpoint yang benar-benar bersih untuk fetch data
// Disable semua output yang tidak perlu
ini_set('display_errors', 0);
ini_set('log_errors', 0);
error_reporting(0);

// Clean semua output buffer
while (ob_get_level()) {
    ob_end_clean();
}

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: *');

try {
    // Database connection
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'inventory_db';
    
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8");
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed");
    }
    
    // Query data
    $sql = "SELECT id, name, type, quantity, created_at, updated_at FROM products ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed");
    }
    
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'type' => $row['type'],
            'quantity' => (int)$row['quantity'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
    }
    
    $response = [
        'success' => true,
        'data' => $products,
        'count' => count($products)
    ];
    
    $conn->close();
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

// Output JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>
