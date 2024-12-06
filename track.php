<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if(!isset($_GET['id'])) {
    header("Location: tracks.php");
    exit;
}
$track_id = $_GET['id'];
$sql = "SELECT * FROM tracks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $track_id);
$stmt->execute();
$result = $stmt->get_result();
$track = $result->fetch_assoc();

if(!$track) {
    header("Location: tracks.php");
    exit;
}
?>

<div class="container">
    <div class="track-details">
        <h1><?php echo htmlspecialchars($track['name']); ?></h1>
        
        <img src="<?php echo htmlspecialchars($track['image_url']); ?>"
             alt="<?php echo htmlspecialchars($track['name']); ?>">
        
        <div class="track-info">
            <p><strong>Country:</strong> <?php echo htmlspecialchars($track['country']); ?></p>
            <p><strong>Length:</strong> <?php echo htmlspecialchars($track['length_km']); ?> km</p>
            <p><strong>Lap Record:</strong> <?php echo htmlspecialchars($track['fastest_lap']); ?></p>
            <p><strong>Record Holder:</strong> <?php echo htmlspecialchars($track['lap_record_holder']); ?></p>
            <p><?php echo htmlspecialchars($track['description']); ?></p>
        </div>

        <?php if(isset($_SESSION['user_id'])): ?>
        <div class="review-form">
            <h2>Write a Review</h2>
            <form method="POST" action="add_review.php" onsubmit="return validateReviewForm()">
                <input type="hidden" name="track_id" value="<?php echo $track_id; ?>">
                
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <div class="rating-container">
                        <input type="number" id="rating" name="rating" min="1" max="5" required>
                        <span class="rating-label">/5 stars</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="comment">Your Review</label>
                    <textarea id="comment" name="comment" rows="4" required placeholder="Share your experience..."></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Submit Review</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="reviews">
            <h2>Reviews</h2>
            <?php
            $sql = "SELECT r.*, u.username FROM reviews r
                    JOIN users u ON r.user_id = u.id
                    WHERE r.track_id = ?
                    ORDER BY r.created_at DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $track_id);
            $stmt->execute();
            $reviews = $stmt->get_result();
            
            if ($reviews->num_rows == 0) {
                echo "<p class='text-center' style='color: #999;'>No reviews yet. Be the first to review!</p>";
            }
            
            while($review = $reviews->fetch_assoc()):
            ?>
            <div class="review">
                <p><strong><?php echo htmlspecialchars($review['username']); ?></strong> - 
                 Rating: <?php echo $review['rating']; ?>/5</p>
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                <p class="date">Posted on <?php echo date('M d, Y', strtotime($review['created_at'])); ?></p>
                
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                <form method="POST" action="delete_review.php" style="display: inline;">
                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                    <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                </form>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
function validateReviewForm() {
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value;

    if (rating < 1 || rating > 5) {
        alert('Please select a rating between 1 and 5.');
        return false;
    }

    if (comment.trim() === '') {
        alert('Please write a review comment.');
        return false;
    }

    return true;
}
</script>