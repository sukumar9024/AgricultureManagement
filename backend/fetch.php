<?php
// Include the database connection
include 'db.php';

// Check if the state and district are set in the POST request
if (isset($_POST['state']) && isset($_POST['district'])) {
    // Sanitize the inputs to prevent SQL injection
    $selectedState = mysqli_real_escape_string($connection, $_POST['state']);
    $selectedDistrict = mysqli_real_escape_string($connection, $_POST['district']);

    // Perform a database query to fetch data based on the selected state and district
    $query = "SELECT * FROM product WHERE state = '$selectedState' AND district = '$selectedDistrict'";
    $result = mysqli_query($connection, $query);

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch data as an associative array
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // Return the fetched data as JSON
        echo json_encode($data);
    } else {
        // If no items are present, return a message
        echo json_encode(["message" => "No items found"]);
    }
} else {
    // If state and district are not set in the POST request, return an error message
    echo json_encode(["error" => "State and district parameters are required"]);
}
?>
