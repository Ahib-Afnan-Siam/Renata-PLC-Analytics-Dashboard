<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link rel="stylesheet" href="register.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="register-container">
    <!-- Left side form -->
    <div class="register-form-section">
      <h1>Hello,<br>Create Account</h1>
      <p>Join the dashboard to explore insights</p>

      <form action="handle_register.php" method="POST" class="register-form">
        <?php if (isset($_GET['error'])): ?>
          <div class="error-message">
            <?= htmlspecialchars($_GET['error']) ?>
          </div>
        <?php endif; ?>
        
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="confirm_password" placeholder="Confirm Password" required />

        <button type="submit">Sign Up</button>

        <p class="login-link">
          Already have an account? <a href="../login/login.html">Login</a>
        </p>
      </form>
    </div>

    <!-- Right side image -->
    <div class="register-illustration">
      <img src="../login/assets/log-new.jpg" alt="Register Illustration" />
    </div>
  </div>
</body>
</html>
