<?php
require_once 'includes/config.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit;
}
require_once 'includes/header.php';
?>

<div class="hero-section">
    <video autoplay muted loop id="myVideo">
        <source src="videos/AdobeStock_426768593.mov" type="video/quicktime">
    </video>

    <div class="dashboard-content">
        <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        
        <div class="dashboard-buttons">
            <a href="tracks.php" class="dashboard-btn">
                Explore Tracks
            </a>
            <a href="drivers.php" class="dashboard-btn">
                Meet the Drivers
            </a>
            <a href="cars.php" class="dashboard-btn">
                Discover Cars
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>