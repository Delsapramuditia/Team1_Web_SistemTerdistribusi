<?php
include 'db.php';

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="products_export_' . date('Y-m-d_H-i-s') . '.csv"');

// Create output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['ID', 'Product Name', 'Type', 'Quantity', 'Created At', 'Updated At']);

// Get all products
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['type'],
            $row['quantity'],
            $row['created_at'],
            $row['updated_at']
        ]);
    }
}

fclose($output);
$conn->close();
?>
