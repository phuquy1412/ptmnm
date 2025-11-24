<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$student = array(
    "studentId" => "DH52201328",
    "name" => "Hồ Phú Quý",
    "class" => "D22_TH10"
);

echo json_encode($student);
?>
