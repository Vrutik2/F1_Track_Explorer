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
    
    // Verify the favorite exists and belongs to the user
    $check_favorite = "SELECT id FROM favorites WHERE user_id = ? AND track_id = ?";
    $stmt = $conn->prepare($check_favorite);
    $stmt->bind_param("ii", $user_id, $track_id);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        // Remove from favorites
        $sql = "DELETE FROM favorites WHERE user_id = ? AND track_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $track_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Track removed from favorites.";
        } else {
            $_SESSION['error'] = "Error removing track from favorites.";
        }
    } else {
        $_SESSION['error'] = "Track not found in favorites.";
    }
}

// Determine where to redirect
if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'favorites.php') !== false) {
    header("Location: favorites.php");
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
exit;