<?php
// Debug script untuk melihat response dari fetch.php
echo "<h2>Debug Fetch Response</h2>";

// Capture output dari fetch.php
ob_start();
include 'fetch.php';
$response = ob_get_clean();

echo "<h3>Raw Response:</h3>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd; max-height: 300px; overflow: auto;'>";
echo htmlspecialchars($response);
echo "</pre>";

echo "<h3>Response Length:</h3>";
echo strlen($response) . " characters";

echo "<h3>Response Analysis:</h3>";
if (strpos($response, '<') !== false) {
    echo "<p>⚠️ Response contains HTML tags (this causes JSON parse error)</p>";

    // Try to extract JSON part
    $json_start = strpos($response, '{');
    if ($json_start !== false) {
        $json_part = substr($response, $json_start);
        echo "<h4>Extracted JSON part:</h4>";
        echo "<pre style='background: #e8f5e8; padding: 10px; border: 1px solid #4CAF50;'>";
        echo htmlspecialchars($json_part);
        echo "</pre>";

        // Try to decode the JSON part
        $decoded = json_decode($json_part, true);
        if ($decoded !== null) {
            echo "<h4>✅ JSON decode successful:</h4>";
            echo "<pre>";
            print_r($decoded);
            echo "</pre>";
        } else {
            echo "<h4>❌ JSON decode failed: " . json_last_error_msg() . "</h4>";
        }
    }
} else {
    // Try to decode JSON
    echo "<h3>JSON Decode Test:</h3>";
    $decoded = json_decode($response, true);
    if ($decoded === null) {
        echo "❌ JSON decode failed. Error: " . json_last_error_msg();
    } else {
        echo "✅ JSON decode successful";
        echo "<pre>";
        print_r($decoded);
        echo "</pre>";
    }
}

echo "<hr>";
echo "<h3>Quick Fixes:</h3>";
echo "<p>1. <a href='fix_database.php'>Fix Database Structure</a></p>";
echo "<p>2. <a href='test_connection.php'>Test Database Connection</a></p>";
echo "<p>3. <a href='dashboard.html'>Back to Dashboard</a></p>";
?>