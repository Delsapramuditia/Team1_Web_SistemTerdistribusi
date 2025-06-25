<?php
// Clean all output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Start fresh output buffer
ob_start();

// Set proper headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

// Disable all error output
ini_set('display_errors', 0);
ini_set('log_errors', 0);
error_reporting(0);

try {
    // Include database connection
    include 'db.php';
    
    // Check if connection exists
    if (!isset($conn) || $conn->connect_error) {
        throw new Exception("Database connection failed");
    }
    
    // First, check what columns exist in the table
    $columns_query = "SHOW COLUMNS FROM products";
    $columns_result = $conn->query($columns_query);
    
    $available_columns = [];
    while ($column = $columns_result->fetch_assoc()) {
        $available_columns[] = $column['Field'];
    }
    
    // Build SELECT query based on available columns
    $select_fields = ['id', 'name', 'type', 'quantity'];
    
    // Add timestamp columns if they exist
    if (in_array('created_at', $available_columns)) {
        $select_fields[] = 'created_at';
    }
    if (in_array('updated_at', $available_columns)) {
        $select_fields[] = 'updated_at';
    }
    
    // Build the query
    $sql = "SELECT " . implode(', ', $select_fields) . " FROM products";
    
    // Add ORDER BY only if created_at exists, otherwise use id
    if (in_array('created_at', $available_columns)) {
        $sql .= " ORDER BY created_at DESC";
    } else {
        $sql .= " ORDER BY id DESC";
    }
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query execution failed: " . $conn->error);
    }
    
    // Fetch all products
    $products = array();
    while($row = $result->fetch_assoc()) {
        $product = array(
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'type' => $row['type'],
            'quantity' => (int)$row['quantity']
        );
        
        // Add timestamp fields if they exist
        if (isset($row['created_at'])) {
            $product['created_at'] = $row['created_at'];
        }
        if (isset($row['updated_at'])) {
            $product['updated_at'] = $row['updated_at'];
        }
        
        $products[] = $product;
    }
    
    // Return success response
    $response = array(
        'success' => true,
        'data' => $products,
        'count' => count($products),
        'columns' => $available_columns,
        'timestamp' => date('Y-m-d H:i:s')
    );
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Return error response
    $response = array(
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    );
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

// Close connection if exists
if (isset($conn)) {
    $conn->close();
}

// Clean output and send JSON
$json_output = ob_get_clean();
if (empty($json_output)) {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} else {
    // If there's unwanted output, clean it and send only JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
exit();
?>
