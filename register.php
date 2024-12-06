<?php
require_once 'includes/config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if($stmt->execute()) {
        $success_message = "Registration successful! Please login with your credentials.";
        echo "<script>window.onload = function() { showLogin(); }</script>";
    } else {
        $error_message = "Registration failed. Username or email may already exist.";
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
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
            header("Location: dashboard.php");
            exit;
        }
    }
    $login_error = "Invalid username or password";
}

require_once 'includes/header.php';
?>

<div class="auth-container">
    <div class="auth-tabs">
        <button class="auth-tab active" onclick="showRegister()">Register</button>
        <button class="auth-tab" onclick="showLogin()">Login</button>
    </div>

    <div id="register-form">
        <h2 class="form-title">Create Account</h2>
        <?php if(isset($error_message)) echo "<div class='error-message'>$error_message</div>"; ?>
        
        <form class="auth-form" method="POST" onsubmit="return validateRegistrationForm()">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="register" class="submit-btn">Create Account</button>
        </form>
    </div>

    <div id="login-form" style="display: none;">
        <h2 class="form-title">Welcome Back</h2>
        <?php 
        if(isset($success_message)) echo "<div class='success-message'>$success_message</div>";
        if(isset($login_error)) echo "<div class='error-message'>$login_error</div>";
        ?>
        
        <form class="auth-form" method="POST" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="remember_me" id="remember" style="width: auto; margin-right: 10px;">
                <label for="remember" style="margin: 0;">Remember me</label>
            </div>
            
            <button type="submit" name="login" class="submit-btn">Login</button>
        </form>
    </div>
</div>

<script>
function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
    document.querySelectorAll('.auth-tab')[1].classList.add('active');
    document.querySelectorAll('.auth-tab')[0].classList.remove('active');
}

function showRegister() {
    document.getElementById('register-form').style.display = 'block';
    document.getElementById('login-form').style.display = 'none';
    document.querySelectorAll('.auth-tab')[0].classList.add('active');
    document.querySelectorAll('.auth-tab')[1].classList.remove('active');
}

<?php if(isset($success_message)): ?>
window.onload = function() {
    showLogin();
}
<?php endif; ?>
</script>

<?php require_once 'includes/footer.php'; ?>