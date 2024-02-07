<?php
header('Access-Control-Allow-Origin: *');
include("conn.php");

// Check if the required fields are present in the request
if (
    isset($_REQUEST['id_card']) &&
    isset($_REQUEST['titlename']) &&
    isset($_REQUEST['firstname']) &&
    isset($_REQUEST['lastname']) &&
    isset($_REQUEST['date_of_birth']) &&
    isset($_REQUEST['heart_value']) &&
    isset($_REQUEST['pulse_value'])
) {

    // Receive values from HTTP Request
    $idCard = $_REQUEST['id_card'];
    $titleName = $_REQUEST['titlename'];
    $firstName = $_REQUEST['firstname'];
    $lastName = $_REQUEST['lastname'];
    $dob = $_REQUEST['date_of_birth'];
    $heartValue = $_REQUEST['heart_value'];
    $pulseValue = $_REQUEST['pulse_value'];

    // Calculate the new id based on existing data
    $sql ="SELECT MAX(id) AS MAX_ID FROM health_info ";
    $objQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $no = 1; // Default value
    while ($row1 = mysqli_fetch_array($objQuery)) {
        if ($row1["MAX_ID"] != "") {
            $no = $row1["MAX_ID"] + 1;
        }
    }

    // Prepare SQL command and execute
    $sql = "INSERT INTO health_info (id, id_card, titlename, firstname, lastname, date_of_birth, heart_value, pulse_value) 
            VALUES ('$no', '$idCard', '$titleName', '$firstName', '$lastName', '$dob', '$heartValue', '$pulseValue')";

    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        http_response_code(200);
        echo "Health information saved successfully. New ID: $no";
    } else {
        http_response_code(500);
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If required fields are not present in the request, return a Bad Request response
    http_response_code(400);
    echo "Error: Incomplete request data.";
}
?>
