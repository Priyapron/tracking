<?php

// กำหนดค่าที่เชื่อมต่อกับฐานข้อมูลของคุณ
header('Access-Control-Allow-Origin: *');
include("conn.php");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่า id ที่ต้องการลบจาก request
$patient_id = $_GET['id'];

// สร้างคำสั่ง SQL สำหรับลบข้อมูล
$sql = "DELETE FROM health_info WHERE id = $patient_id";

// ทำการลบข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();

?>
