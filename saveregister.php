<?php
header('Access-Control-Allow-Origin: *');
include("conn.php");

// ตรวจสอบว่ามีรีเควสที่ส่งมาหรือไม่
if (isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['dob']) &&
    isset($_REQUEST['email']) && isset($_REQUEST['phone']) && isset($_REQUEST['password'])) {

    // รับค่าจาก HTTP Request
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $dob = $_REQUEST['dob'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $password = $_REQUEST['password'];

    // คำนวณหาเลขที่ ID ล่าสุด
    $sql ="SELECT MAX(user_id) AS MAX_ID FROM idoo_user ";
    $objQuery = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $no = 1; // ตั้งค่าเริ่มต้น
    while ($row1 = mysqli_fetch_array($objQuery)) {
        if ($row1["MAX_ID"] != "") {
            $no = $row1["MAX_ID"] + 1;
        }
    }

    // สร้าง user_id ใหม่
    $newno = "" . (string) $no;
    $newno = str_pad($newno, 5, '0', STR_PAD_LEFT);
    $newuserid = $newno;

    // เตรียมคำสั่ง SQL และทำการ execute
    $sql = "INSERT INTO idoo_user(user_id, firstname, email, phone, password, lastname, dob) 
            VALUES ('$newuserid', '$firstname', '$email', '$phone', '$password', '$lastname', '$dob')";

    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่า query สำเร็จหรือไม่
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
        echo "Error: " . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อ
    mysqli_close($conn);

} else {
    // ถ้าไม่มีรีเควสที่ส่งมา, ไม่ต้องทำอะไร
    http_response_code(400); // Bad Request
    echo "Error: Incomplete request data.";
}
?>