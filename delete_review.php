<?php
require_once 'includes/config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_id'])) {
    $review_id = $_POST['review_id'];
    $user_id = $_SESSION['user_id'];
    
    $sql = "DELETE FROM reviews WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $review_id, $user_id);
    $stmt->execute();
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}