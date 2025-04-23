<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laravel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get the user_id from query parameters or use a default
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

// Prepare SQL query based on whether user_id is provided
if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM lists WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM lists");
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();

$lists = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format each list item
        $list = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'images' => $row['images'],
            'name' => $row['name'],
            'price' => $row['price'],
            'size' => $row['size'],
            'color' => $row['color'],
            'quantity' => $row['quantity'],
            'user_id' => $row['user_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
        $lists[] = $list;
    }
}

// Close connections
$stmt->close();
$conn->close();

// Return JSON response
http_response_code(200);
echo json_encode($lists);
?>
