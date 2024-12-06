<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<div class="content-container">
    <h1 class="page-title">F1 Drivers 2024</h1>
    
    <div class="teams-grid">
        <?php
        $sql = "SELECT t.*, GROUP_CONCAT(d.name) as drivers 
                FROM teams t 
                LEFT JOIN drivers d ON t.id = d.team_id 
                GROUP BY t.id 
                ORDER BY t.name";
        $result = $conn->query($sql);
        
        while($team = $result->fetch_assoc()): ?>
            <div class="team-card">
                <div class="team-header">
                    <img src="<?php echo htmlspecialchars($team['logo_url']); ?>" alt="<?php echo htmlspecialchars($team['name']); ?> logo" class="team-logo">
                    <h2><?php echo htmlspecialchars($team['name']); ?></h2>
                </div>
                
                <?php
                $driver_sql = "SELECT * FROM drivers WHERE team_id = ?";
                $stmt = $conn->prepare($driver_sql);
                $stmt->bind_param("i", $team['id']);
                $stmt->execute();
                $drivers = $stmt->get_result();
                
                while($driver = $drivers->fetch_assoc()): ?>
                    <div class="driver-card">
                        <img src="<?php echo htmlspecialchars($driver['image_url']); ?>" alt="<?php echo htmlspecialchars($driver['name']); ?>" class="driver-image">
                        <div class="driver-info">
                            <h3><?php echo htmlspecialchars($driver['name']); ?></h3>
                            <p>Number: <?php echo $driver['number']; ?></p>
                            <p>Nationality: <?php echo htmlspecialchars($driver['nationality']); ?></p>
                            <p>Wins: <?php echo $driver['wins']; ?></p>
                            <p>Podiums: <?php echo $driver['podiums']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>