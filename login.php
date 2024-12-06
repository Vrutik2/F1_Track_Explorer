<?php
require_once 'includes/config.php';

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            if(isset($_POST['remember_me'])) {
                setcookie('user_login', $user['username'], time() + (86400 * 30), "/");
            }
            
            header("Location: index.php");
            exit;
        }
    }
    
    $error = "Invalid username or password";
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST" action="" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember_me"> Remember me
                </label>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>