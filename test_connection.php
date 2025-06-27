<?php
echo "<h2>Database Connection Test</h2>";

// Test basic PHP
echo "<p>✅ PHP is working</p>";

// Test MySQL extension
if (extension_loaded('mysqli')) {
    echo "<p>✅ MySQLi extension is loaded</p>";
} else {
    echo "<p>❌ MySQLi extension is NOT loaded</p>";
}

// Test database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'inventory_db';

echo "<h3>Testing Connection Parameters:</h3>";
echo "<p>Host: $host</p>";
echo "<p>User: $user</p>";
echo "<p>Password: " . (empty($pass) ? 'empty' : 'set') . "</p>";
echo "<p>Database: $dbname</p>";

try {
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p>✅ Connected to MySQL server</p>";
    
    // Check if database exists
    $result = $conn->query("SHOW DATABASES LIKE '$dbname'");
    if ($result->num_rows > 0) {
        echo "<p>✅ Database '$dbname' exists</p>";
        
        // Connect to database
        $conn->select_db($dbname);
        
        // Check if table exists
        $result = $conn->query("SHOW TABLES LIKE 'products'");
        if ($result->num_rows > 0) {
            echo "<p>✅ Table 'products' exists</p>";
            
            // Count records
            $result = $conn->query("SELECT COUNT(*) as count FROM products");
            $row = $result->fetch_assoc();
            echo "<p>✅ Products table has " . $row['count'] . " records</p>";
            
        } else {
            echo "<p>❌ Table 'products' does NOT exist</p>";
            echo "<p>Creating table...</p>";
            
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
                echo "<p>✅ Table 'products' created successfully</p>";
                
                // Insert dummy data
                $insert_dummy = "
                INSERT INTO products (name, type, quantity) VALUES
                ('Laptop Dell XPS', 'Electronics', 5),
                ('T-Shirt Cotton', 'Clothing', 20),
                ('Smartphone Samsung', 'Electronics', 8),
                ('Jeans Levis', 'Clothing', 15),
                ('Headphones Sony', 'Electronics', 12)";
                
                if ($conn->query($insert_dummy)) {
                    echo "<p>✅ Dummy data inserted successfully</p>";
                } else {
                    echo "<p>❌ Error inserting dummy data: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>❌ Error creating table: " . $conn->error . "</p>";
            }
        }
        
    } else {
        echo "<p>❌ Database '$dbname' does NOT exist</p>";
        echo "<p>Creating database...</p>";
        
        if ($conn->query("CREATE DATABASE $dbname")) {
            echo "<p>✅ Database '$dbname' created successfully</p>";
            echo "<p>Please refresh this page to continue setup</p>";
        } else {
            echo "<p>❌ Error creating database: " . $conn->error . "</p>";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<p>1. If all tests pass, go to: <a href='index.html'>Your Application</a></p>";
echo "<p>2. If there are errors, check XAMPP Control Panel</p>";
echo "<p>3. Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></p>";
?>
