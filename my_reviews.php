<?php
require_once 'includes/config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT r.*, t.name as track_name 
        FROM reviews r 
        JOIN tracks t ON r.track_id = t.id 
        WHERE r.user_id = ? 
        ORDER BY r.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

require_once 'includes/header.php';
?>

<div class="container" style="padding-top: 80px;">
    <div class="reviews">
        <?php while($review = $result->fetch_assoc()): ?>
            <div class="review">
                <div class="review-content">
                    <h3><?php echo htmlspecialchars($review['track_name']); ?></h3>
                    <div class="rating">Rating: <?php echo $review['rating']; ?>/5</div>
                    <p class="comment"><?php echo htmlspecialchars($review['comment']); ?></p>
                    <p class="date">Posted on <?php echo date('M d, Y', strtotime($review['created_at'])); ?></p>
                </div>
                
                <div class="review-actions">
                    <form method="POST" action="delete_review.php" style="display: inline;">
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this review?')">
                            Delete Review
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
