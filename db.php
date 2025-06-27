<?php
// Disable output buffering and error display for clean JSON responses
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
    strpos($_SERVER['REQUEST_URI'], '.php') !== false) {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'inventory_db';

// Enable error reporting untuk debugging
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Membuat koneksi dengan error handling
try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    // Set charset untuk menghindari masalah encoding
    $conn->set_charset("utf8");
    
    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Test query untuk memastikan database dan tabel ada
    $test_query = "SHOW TABLES LIKE 'products'";
    $result = $conn->query($test_query);
    
    if ($result->num_rows == 0) {
        // Jika tabel tidak ada, buat tabel dengan struktur lengkap
        $create_table = "
        CREATE TABLE products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(100) NOT NULL,
            quantity INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($create_table)) {
            // Insert data dummy jika tabel baru dibuat
            $insert_dummy = "
            INSERT INTO products (name, type, quantity) VALUES
            ('Laptop Dell XPS', 'Electronics', 5),
            ('T-Shirt Cotton', 'Clothing', 20),
            ('Smartphone Samsung', 'Electronics', 8),
            ('Jeans Levis', 'Clothing', 15),
            ('Headphones Sony', 'Electronics', 12)";
            $conn->query($insert_dummy);
        }
    } else {
        // Tabel ada, cek apakah kolom timestamp ada
        $columns_query = "SHOW COLUMNS FROM products";
        $columns_result = $conn->query($columns_query);
        
        $existing_columns = [];
        while ($column = $columns_result->fetch_assoc()) {
            $existing_columns[] = $column['Field'];
        }
        
        // Tambahkan kolom yang hilang
        if (!in_array('created_at', $existing_columns)) {
            $conn->query("ALTER TABLE products ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        }
        
        if (!in_array('updated_at', $existing_columns)) {
            $conn->query("ALTER TABLE products ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        }
    }
    
} catch (Exception $e) {
    // For AJAX requests, don't output HTML errors
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'Database connection error: ' . $e->getMessage()
        ]);
        exit();
    } else {
        // For direct access, show detailed error
        die("Database Error: " . $e->getMessage() . "<br><br>
             <strong>Troubleshooting Steps:</strong><br>
             1. Make sure XAMPP is running (Apache + MySQL)<br>
             2. Check if MySQL service is started<br>
             3. Verify database credentials<br>
             4. Open <a href='http://localhost/phpmyadmin'>phpMyAdmin</a><br>
             5. Try running: <a href='test_connection.php'>Connection Test</a>");
    }
}
?>
