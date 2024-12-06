<?php 
require_once 'includes/config.php'; 
require_once 'includes/header.php'; ?>

<div class="content-container">
    <h1 class="page-title">F1 Cars 2024</h1>
    <div class="cars-grid">
        <?php 
        $sql = "SELECT t.name as team_name, t.logo_url, c.* FROM cars c JOIN teams t ON c.team_id = t.id WHERE c.season_year = 2024 ORDER BY t.name";
        $result = $conn->query($sql);
        while($car = $result->fetch_assoc()): 
        ?>
        <div class="car-card">
            <div class="team-header">
                <img src="<?php echo htmlspecialchars($car['logo_url'] ?? ''); ?>" 
                     alt="<?php echo htmlspecialchars($car['team_name'] ?? ''); ?> logo" 
                     class="team-logo">
                <h2><?php echo htmlspecialchars($car['team_name'] ?? ''); ?></h2>
            </div>
            <div class="car-details">
                <img src="<?php echo htmlspecialchars($car['image_url'] ?? ''); ?>" 
                     alt="<?php echo htmlspecialchars($car['model_name'] ?? ''); ?>" 
                     class="car-image">
                <h3><?php echo htmlspecialchars($car['model_name'] ?? ''); ?></h3>
                <div class="car-specs">
                    <p><strong>Engine:</strong> <?php echo htmlspecialchars($car['engine_supplier'] ?? ''); ?></p>
                    <p class="car-description"><?php echo htmlspecialchars($car['description'] ?? ''); ?></p>
                    <div class="technical-specs">
                        <?php echo nl2br(htmlspecialchars($car['specs'] ?? '')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>