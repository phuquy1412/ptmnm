<?php
$host = "sql100.infinityfree.com";
$user = "if0_40496600";
$pass = "zJVxGqG7LvO";
$dbname = "if0_40496600_student_management";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die(json_encode([
        "success" => false,
        "message" => "Không kết nối được MySssssssssQL: " . mysqli_connect_error()
    ]));
}

mysqli_set_charset($conn, "utf8");
?>
