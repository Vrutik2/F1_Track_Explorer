<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Track Explorer</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <div class="logo">F1 Track Explorer</div>
        <ul>
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            if($current_page == 'register.php'): ?>
                <li><a href="index.php">Home</a></li>
                
            <?php elseif($current_page == 'index.php'): ?>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <li><a href="register.php" class="signup-btn">Sign Up</a></li>
                <?php endif; ?>
                
            <?php elseif($current_page == 'dashboard.php'): ?>
                <li><a href="tracks.php">Tracks</a></li>
                <li><a href="drivers.php">Drivers</a></li>
                <li><a href="cars.php">Cars</a></li>
                <li><a href="my_reviews.php">My Reviews</a></li>
                <li><a href="favorites.php">Favorites</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
                
            <?php else: ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="tracks.php">Tracks</a></li>
                <li><a href="drivers.php">Drivers</a></li>
                <li><a href="cars.php">Cars</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="my_reviews.php">My Reviews</a></li>
                    <li><a href="favorites.php">Favorites</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="register.php" class="signup-btn">Sign Up</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </nav>