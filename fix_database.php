<?php
echo "<h2>Database Structure Fix</h2>";

include 'db.php';

try {
    // Check current table structure
    echo "<h3>Current Table Structure:</h3>";
    $columns_query = "SHOW COLUMNS FROM products";
    $columns_result = $conn->query($columns_query);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    $existing_columns = [];
    while ($column = $columns_result->fetch_assoc()) {
        $existing_columns[] = $column['Field'];
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check if we need to add columns
    $needs_fix = false;
    
    if (!in_array('created_at', $existing_columns)) {
        echo "<p>❌ Column 'created_at' is missing</p>";
        $needs_fix = true;
    } else {
        echo "<p>✅ Column 'created_at' exists</p>";
    }
    
    if (!in_array('updated_at', $existing_columns)) {
        echo "<p>❌ Column 'updated_at' is missing</p>";
        $needs_fix = true;
    } else {
        echo "<p>✅ Column 'updated_at' exists</p>";
    }
    
    if ($needs_fix) {
        echo "<h3>Fixing Table Structure...</h3>";
        
        // Add missing columns
        if (!in_array('created_at', $existing_columns)) {
            $add_created = "ALTER TABLE products ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
            if ($conn->query($add_created)) {
                echo "<p>✅ Added 'created_at' column</p>";
            } else {
                echo "<p>❌ Error adding 'created_at': " . $conn->error . "</p>";
            }
        }
        
        if (!in_array('updated_at', $existing_columns)) {
            $add_updated = "ALTER TABLE products ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
            if ($conn->query($add_updated)) {
                echo "<p>✅ Added 'updated_at' column</p>";
            } else {
                echo "<p>❌ Error adding 'updated_at': " . $conn->error . "</p>";
            }
        }
        
        echo "<h3>Updated Table Structure:</h3>";
        $columns_query = "SHOW COLUMNS FROM products";
        $columns_result = $conn->query($columns_query);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        while ($column = $columns_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "<td>" . $column['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p>✅ Table structure is correct!</p>";
    }
    
    // Test fetch
    echo "<h3>Testing Data Fetch:</h3>";
    $test_query = "SELECT * FROM products LIMIT 3";
    $test_result = $conn->query($test_query);
    
    if ($test_result && $test_result->num_rows > 0) {
        echo "<p>✅ Data fetch successful</p>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        
        // Get column names
        $fields = $test_result->fetch_fields();
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        
        // Reset result pointer
        $test_result->data_seek(0);
        
        // Show data
        while ($row = $test_result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ No data found or query failed</p>";
    }
    
    $conn->close();
    
    echo "<hr>";
    echo "<h3>Next Steps:</h3>";
    echo "<p>1. Go back to your application: <a href='dashboard.html'>Dashboard</a></p>";
    echo "<p>2. Test fetch API: <a href='fetch.php'>fetch.php</a></p>";
    echo "<p>3. Debug response: <a href='debug_fetch.php'>debug_fetch.php</a></p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>
