<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass);

// Tạo database
$conn->query("CREATE DATABASE IF NOT EXISTS student_management");
$conn->select_db("student_management");

// Tạo bảng
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    major VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql);
echo "Database và bảng đã được tạoooooooo!";
$conn->close();
?>
