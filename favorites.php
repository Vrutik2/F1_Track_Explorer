<?php
require_once 'includes/config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT t.* FROM tracks t 
        JOIN favorites f ON t.id = f.track_id 
        WHERE f.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

require_once 'includes/header.php';
?>

<div class="container" style="padding-top: 80px;">
    <h2 class="favorites-title">My Favorite Tracks</h2>
    
    <div class="track-grid">
        <?php while($track = $result->fetch_assoc()): ?>
            <div class="track-card">
                <img src="<?php echo htmlspecialchars($track['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($track['name']); ?>">
                <div class="track-info">
                    <div class="track-text">
                        <h3><?php echo htmlspecialchars($track['name']); ?></h3>
                        <p>Country: <?php echo htmlspecialchars($track['country']); ?></p>
                        <p>Length: <?php echo htmlspecialchars($track['length_km']); ?> km</p>
                    </div>
                    
                    <div class="track-buttons">
                        <button class="btn view-details-btn" onclick="window.location.href='track.php?id=<?php echo $track['id']; ?>'">
                            View Details
                        </button>
                        
                        <form method="POST" action="remove_favorite.php">
                            <input type="hidden" name="track_id" value="<?php echo $track['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Remove from favorites?')">
                                Remove from Favorites
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>