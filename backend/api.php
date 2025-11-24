<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'student_management';

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Kết nối lỗi']));
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

switch($action) {
    case 'list':
        $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
        $students = [];
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $students]);
        break;

    case 'add':
        if($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $conn->real_escape_string($data['name']);
            $email = $conn->real_escape_string($data['email']);
            $phone = $conn->real_escape_string($data['phone']);
            $major = $conn->real_escape_string($data['major']);

            $sql = "INSERT INTO students (name, email, phone, major) VALUES ('$name', '$email', '$phone', '$major')";
            
            if($conn->query($sql)) {
                echo json_encode(['success' => true, 'message' => 'Thêm thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
        }
        break;

    case 'edit':
        if($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = intval($data['id']);
            $name = $conn->real_escape_string($data['name']);
            $email = $conn->real_escape_string($data['email']);
            $phone = $conn->real_escape_string($data['phone']);
            $major = $conn->real_escape_string($data['major']);

            $sql = "UPDATE students SET name='$name', email='$email', phone='$phone', major='$major' WHERE id=$id";
            
            if($conn->query($sql)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
        }
        break;

    case 'delete':
        if($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = intval($data['id']);
            
            if($conn->query("DELETE FROM students WHERE id=$id")) {
                echo json_encode(['success' => true, 'message' => 'Xóa thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
}

$conn->close();
?>
