<?php
session_start();

// Assuming you have a database connection established in the trains.php file
$mysqli = require __DIR__ . "/trains.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startStation = $_POST["start_station"];

    // Query to retrieve trains from the database based on the start station
    $query = "SELECT * FROM trainbetweenstations WHERE FromStation = '$startStation'";
    $result = $mysqli->query($query);

    // Check if there are any trains found
    if ($result && $result->num_rows > 0) {
        $trainsData = array();

        // Fetch each row from the result set and add it to $trainsData array
        while ($row = $result->fetch_assoc()) {
            $trainsData[] = array(
                "trainName" => $row["TrainName"],
                "runningDays" => $row["RunningDays"],
                "startTime" => $row["SourceTime"],
                "destinationTime" => $row["DestinationTime"],
                "categories" => array(
                    array("name" => "AC3", "seatsAvailable" => 50),
                    array("name" => "AC2", "seatsAvailable" => 30),
                    array("name" => "AC1", "seatsAvailable" => 20)
                    // Add more categories as needed
                )
            );
        }

        // Pass $trainsData to the HTML page using session variable
        $_SESSION["trainsData"] = $trainsData;

        // Redirect to train_results.html
        header("Location: train_results.php");
        exit();
    } else {
        echo "No trains found for the given start station.";
    }

    // Close the database connection
    $mysqli->close();
}
?>
