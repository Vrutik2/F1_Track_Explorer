<?php
require_once 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['track_id'])) {
    $user_id = $_SESSION['user_id'];
    $track_id = $_POST['track_id'];
    
    // Check if track exists
    $check_track = "SELECT id FROM tracks WHERE id = ?";
    $stmt = $conn->prepare($check_track);
    $stmt->bind_param("i", $track_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Track not found.";
        header("Location: tracks.php");
        exit;
    }
    
    // Check if already in favorites
    $check_favorite = "SELECT id FROM favorites WHERE user_id = ? AND track_id = ?";
    $stmt = $conn->prepare($check_favorite);
    $stmt->bind_param("ii", $user_id, $track_id);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        // Add to favorites
        $sql = "INSERT INTO favorites (user_id, track_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $track_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Track added to favorites!";
        } else {
            $_SESSION['error'] = "Error adding track to favorites.";
        }
    } else {
        $_SESSION['error'] = "Track is already in favorites.";
    }
}

// Redirect back to previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;