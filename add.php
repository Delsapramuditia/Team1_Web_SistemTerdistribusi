<?php
// Disable error display for clean redirects
ini_set('display_errors', 0);
error_reporting(0);

// Include database connection
include 'db.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate input
        $name = trim($_POST['name'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $quantity = intval($_POST['quantity'] ?? 0);
        
        // Validation
        if (empty($name) || empty($type) || $quantity < 0) {
            throw new Exception("All fields are required and quantity must be non-negative.");
        }
        
        // Check if connection exists
        if (!isset($conn) || $conn->connect_error) {
            throw new Exception("Database connection failed");
        }
        
        // Prepared statement untuk mencegah SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, type, quantity) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ssi", $name, $type, $quantity);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            
            // Redirect to dashboard with success message
            header("Location: dashboard.html?success=added");
            exit();
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
    } catch (Exception $e) {
        // Return error message
        echo "Error adding product: " . $e->getMessage();
        if (isset($conn)) {
            $conn->close();
        }
        exit();
    }
} else {
    // If not POST request, redirect to add form
    header("Location: add.html");
    exit();
}
?>
