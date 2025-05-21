<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../controllers/AdminController.php';
$adminController = new AdminController();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'delete_reservation':
            $reservation_id = $_POST['reservation_id'] ?? 0;
            $result = $adminController->deleteReservation($reservation_id);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            break;
            
        case 'update_reservation':
            $result = $adminController->updateReservation($_POST);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            break;
            
        default:
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    
    switch($action) {
        case 'get_reservation':
            $reservation_id = $_GET['reservation_id'] ?? 0;
            $reservation = $adminController->getReservationById($reservation_id);
            
            header('Content-Type: application/json');
            echo json_encode($reservation);
            break;
            
        default:
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
}
?>