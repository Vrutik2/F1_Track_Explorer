function validateLoginForm() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    
    if(username.length < 3) {
        alert('Username must be at least 3 characters long');
        return false;
    }
    
    if(password.length < 6) {
        alert('Password must be at least 6 characters long');
        return false;
    }
    
    return true;
}

function validateRegistrationForm() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if(username.length < 3) {
        alert('Username must be at least 3 characters long');
        return false;
    }
    
    if(!email.includes('@')) {
        alert('Please enter a valid email address');
        return false;
    }
    
    if(password.length < 6) {
        alert('Password must be at least 6 characters long');
        return false;
    }
    
    if(password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }
    
    return true;
}

function validateReviewForm() {
    const rating = document.getElementById('rating').value;
    const comment = document.getElementById('comment').value.trim();
    
    if(rating < 1 || rating > 5) {
        alert('Rating must be between 1 and 5');
        return false;
    }
    
    if(comment.length < 10) {
        alert('Comment must be at least 10 characters long');
        return false;
    }
    
    return true;
}