<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$sql = "SELECT * FROM tracks ORDER BY name";
$result = $conn->query($sql);
?>

<div class="container" style="padding-top: 80px;">
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
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="add_favorite.php" style="display:inline;">
                                <input type="hidden" name="track_id" value="<?php echo $track['id']; ?>">
                                <button type="submit" class="btn add-favorite-btn">Add to Favorites</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

