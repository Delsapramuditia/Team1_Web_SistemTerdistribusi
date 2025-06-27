<?php
header('Content-Type: application/json');
include 'db.php';

try {
    // Get total products
    $totalResult = $conn->query("SELECT COUNT(*) as total FROM products");
    $totalProducts = $totalResult->fetch_assoc()['total'];
    
    // Get total quantity
    $quantityResult = $conn->query("SELECT SUM(quantity) as total_quantity FROM products");
    $totalQuantity = $quantityResult->fetch_assoc()['total_quantity'] ?? 0;
    
    // Get low stock count (quantity < 5)
    $lowStockResult = $conn->query("SELECT COUNT(*) as low_stock FROM products WHERE quantity < 5");
    $lowStock = $lowStockResult->fetch_assoc()['low_stock'];
    
    // Get products by type
    $typeResult = $conn->query("SELECT type, COUNT(*) as count FROM products GROUP BY type");
    $productsByType = [];
    while ($row = $typeResult->fetch_assoc()) {
        $productsByType[] = $row;
    }
    
    // Get recent products (last 5)
    $recentResult = $conn->query("SELECT name, created_at FROM products ORDER BY created_at DESC LIMIT 5");
    $recentProducts = [];
    while ($row = $recentResult->fetch_assoc()) {
        $recentProducts[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'total_products' => $totalProducts,
            'total_quantity' => $totalQuantity,
            'low_stock' => $lowStock,
            'products_by_type' => $productsByType,
            'recent_products' => $recentProducts
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn->close();
?>
