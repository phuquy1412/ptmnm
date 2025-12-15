<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

// Nhận action từ URL
$action = $_GET['action'] ?? '';

function response($success, $message, $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

// Lấy dữ liệu JSON gửi từ JS
$input = json_decode(file_get_contents("php://input"), true);

// =============================
// 📌 1. LẤY DANH SÁCH SINH VIÊN
// =============================
if ($action === "list") {
    $sql = "SELECT * FROM students ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    response(true, "Lấy danh sách thành công", $students);
}

// =============================
// 📌 2. THÊM SINH VIÊN
// =============================
if ($action === "add") {
    if (!$input || !$input['name'] || !$input['email']) {
        response(false, "Thiếu dữ liệu đầu vào");
    }

    $name = mysqli_real_escape_string($conn, $input['name']);
    $email = mysqli_real_escape_string($conn, $input['email']);
    $phone = mysqli_real_escape_string($conn, $input['phone']);
    $major = mysqli_real_escape_string($conn, $input['major']);

    $sql = "INSERT INTO students (name, email, phone, major) 
            VALUES ('$name', '$email', '$phone', '$major')";

    if (mysqli_query($conn, $sql)) {
        response(true, "Thêm sinh viên thànhhhhhhhhhhhh côngggggg");
    }

    response(false, "Thêm thất bại: " . mysqli_error($conn));
}

// =============================
// 📌 3. SỬA SINH VIÊN
// =============================
if ($action === "edit") {
    if (!$input || !$input['id']) {
        response(false, "Thiếu ID để sửa");
    }

    $id = intval($input['id']);
    $name = mysqli_real_escape_string($conn, $input['name']);
    $email = mysqli_real_escape_string($conn, $input['email']);
    $phone = mysqli_real_escape_string($conn, $input['phone']);
    $major = mysqli_real_escape_string($conn, $input['major']);

    $sql = "UPDATE students 
            SET name='$name', email='$email', phone='$phone', major='$major' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        response(true, "Cập nhật sinh viên thành công");
    }

    response(false, "Sửa thất bại: " . mysqli_error($conn));
}

// =============================
// 📌 4. XÓA SINH VIÊN
// =============================
if ($action === "delete") {
    if (!$input || !$input['id']) {
        response(false, "Thiếu ID để xóa");
    }

    $id = intval($input['id']);
    $sql = "DELETE FROM students WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        response(true, "Xóa thành công");
    }

    response(false, "Xóa thất bại: " . mysqli_error($conn));
}

// Nếu action không hợp lệ
response(false, "Action khônggggg hợppppp lệ");
?>