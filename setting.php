<?php
header('Access-Control-Allow-Origin: *');
include("conn.php");

// ตรวจสอบว่ามีรีเควสที่ส่งมาหรือไม่
if (isset($_REQUEST['imei_no']) && isset($_REQUEST['device_name'])) {

    // รับค่าจาก HTTP Request
    $imei_no = $_POST['imei_no'];
    $device_name = $_POST['device_name'];


    // เตรียมคำสั่ง SQL และทำการ execute
    $sql = "INSERT INTO tb_device (imei_no, device_name) VALUES ('$imei_no', '$device_name')";

    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่า query สำเร็จหรือไม่
    if ($result) {
        http_response_code(200);
        echo "Your setting has been successfully saved";
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