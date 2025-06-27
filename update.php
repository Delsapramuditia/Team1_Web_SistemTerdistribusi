<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update product
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);

    if ($id <= 0 || empty($name) || empty($type) || $quantity < 0) {
        die("Error: All fields are required and quantity must be non-negative.");
    }

    $stmt = $conn->prepare("UPDATE products SET name = ?, type = ?, quantity = ? WHERE id = ?");
    $stmt->bind_param("ssii", $name, $type, $quantity, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: dashboard.html?success=updated");
        exit();
    } else {
        die("Error updating product: " . $conn->error);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Get product data for editing
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'data' => $product]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Product not found']);
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: dashboard.html");
    exit();
}
?>