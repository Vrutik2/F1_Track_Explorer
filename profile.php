<?php
require_once 'includes/config.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user information
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get review count
$review_sql = "SELECT COUNT(*) as review_count FROM reviews WHERE user_id = ?";
$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("i", $user_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();
$review_data = $review_result->fetch_assoc();
$review_count = $review_data['review_count'];

// Get favorite count
$favorite_sql = "SELECT COUNT(*) as favorite_count FROM favorites WHERE user_id = ?";
$favorite_stmt = $conn->prepare($favorite_sql);
$favorite_stmt->bind_param("i", $user_id);
$favorite_stmt->execute();
$favorite_result = $favorite_stmt->get_result();
$favorite_data = $favorite_result->fetch_assoc();
$favorite_count = $favorite_data['favorite_count'];

require_once 'includes/header.php';
?>

<div class="container" style="padding-top: 80px;">
    <h2 class="profile-title">My Profile</h2>
    
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="profile-content">
                <h3>Account Information</h3>
                <div class="info-group">
                    <label>Username</label>
                    <p><?php echo $user ? htmlspecialchars($user['username']) : 'N/A'; ?></p>
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <p><?php echo $user ? htmlspecialchars($user['email']) : 'N/A'; ?></p>
                </div>
                <div class="info-group">
                    <label>Member Since</label>
                    <p><?php echo $user ? date('M d, Y', strtotime($user['created_at'])) : 'N/A'; ?></p>
                </div>
            </div>
        </div>
        <div class="profile-card">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20V10"></path>
                    <path d="M18 20V4"></path>
                    <path d="M6 20v-4"></path>
                </svg>
            </div>
            <div class="profile-content">
                <h3>Activity Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo isset($review_count) ? $review_count : '0'; ?></div>
                        <div class="stat-label">Reviews</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo isset($favorite_count) ? $favorite_count : '0'; ?></div>
                        <div class="stat-label">Favorites</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>