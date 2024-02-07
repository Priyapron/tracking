<?php
include 'conn.php';
header("Access-Control-Allow-Origin: *");

$xcase = $_POST['case'];

// Common variables
$id_card = mysqli_real_escape_string($conn, $_POST['id_card']);
$titlename = mysqli_real_escape_string($conn, $_POST['titlename']);
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
$heart_value = mysqli_real_escape_string($conn, $_POST['heart_value']);
$pulse_value = mysqli_real_escape_string($conn, $_POST['pulse_value']);

$response = array();

switch ($xcase) {
    case '1': // insert
        $sql = "INSERT INTO health_info (id_card, titlename, firstname, lastname, date_of_birth, heart_value, pulse_value)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssss', $id_card, $titlename, $firstname, $lastname, $date_of_birth, $heart_value, $pulse_value);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "User data inserted successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to insert user data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

    case '2': // update
        $sql = "UPDATE health_info
                SET titlename=?, firstname=?, lastname=?,
                    date_of_birth=?, heart_value=?, pulse_value=?
                WHERE id_card=?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssss', $titlename, $firstname, $lastname, $date_of_birth, $heart_value, $pulse_value, $id_card);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 200;
            $response['message'] = "User data updated successfully";
        } else {
            $response['status'] = 500;
            $response['message'] = "Failed to update user data: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        break;

        case '3': // delete
            $sql = "DELETE FROM health_info WHERE id_card=?";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 's', $id_card); // Change 'i' to 's'
            
            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 200;
                $response['message'] = "User data deleted successfully";
            } else {
                $response['status'] = 500;
                $response['message'] = "Failed to delete user data: " . mysqli_error($conn);
            }
            
            mysqli_stmt_close($stmt);
            break;
        
        
    default:
        $response['status'] = 400;
        $response['message'] = "Invalid case provided";
        break;
}

echo json_encode($response);

mysqli_close($conn);
?>
