<?php // start php code block
require 'hash.php'; // include hash utility functions

$message = ''; // initialize message variable for feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // check if form was submitted via post
    $username = $_POST['username']; // get username from form input
    $users = json_decode(file_get_contents('users.json'), true); // load users from json file
    $found = false; // flag to track if user was found
    foreach ($users as &$user) { // loop through users array
        if ($user['username'] == $username) { // check if username matches
            $user['password'] = hashPassword('password'); // reset password to default
            $found = true; // set found flag
            break; // exit loop
        }
    }
    if ($found) { // if user was found
        file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT)); // save updated users to file
        $message = 'Password has been reset to "password". You can now log in.'; // success message
    } else { // if user not found
        $message = 'Username not found.'; // error message
    }
}
?> // end php code block
<!DOCTYPE html> <!-- declare html5 document type -->
<html lang="en"> <!-- html root element with english language -->
<head> <!-- head section for metadata -->
  <meta charset="utf-8"/> <!-- set character encoding to utf-8 -->
  <meta name="viewport" content="width=device-width,initial-scale=1"/> <!-- responsive viewport meta tag -->
  <title>Forgot Password - Pastel Task Manager</title> <!-- page title for browser tab -->
  <link rel="stylesheet" href="style.css"/> <!-- link to external css file -->
  <style> <!-- internal css styles for forgot password page -->
    .forgot-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    .forgot-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      max-width: 420px;
      width: 100%;
      padding: 40px;
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(133, 98, 120, 0.15);
      position: relative;
      z-index: 10;
      animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .forgot-header {
      text-align: center;
      margin-bottom: 32px;
    }
    .forgot-icon {
      font-size: 48px;
      margin-bottom: 16px;
      display: block;
    }
    .forgot-title {
      font-size: 28px;
      font-weight: 700;
      color: #5a2f45;
      margin: 0 0 8px 0;
    }
    .forgot-subtitle {
      font-size: 14px;
      color: #6b495b;
      margin: 0;
    }
    .form-group {
      margin-bottom: 24px;
      position: relative;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #5a2f45;
      font-size: 14px;
    }
    .form-group input {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid rgba(0, 0, 0, 0.06);
      border-radius: 16px;
      background: rgba(255, 255, 255, 0.9);
      font-size: 16px;
      color: #4a2c39;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(5px);
    }
    .form-group input:focus {
      outline: none;
      border-color: #ff6b9d;
      box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.2);
      transform: translateY(-2px);
    }
    .form-group input::placeholder {
      color: #8b6b7a;
    }
    .message {
      padding: 12px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
      animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .success-message {
      background: linear-gradient(135deg, #a8edea, #fed6e3);
      color: #1f6f4b;
      border: 1px solid rgba(168, 237, 234, 0.3);
    }
    .error-message {
      background: linear-gradient(135deg, #ff9a9e, #fecfef);
      color: #8a1a2a;
      border: 1px solid rgba(255, 154, 158, 0.3);
    }
    .reset-btn {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #4ecdc4, #ffe66d);
      color: #255945;
      border: none;
      border-radius: 16px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(133, 98, 120, 0.12);
    }
    .reset-btn:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 12px 30px rgba(133, 98, 120, 0.2);
    }
    .reset-btn:active {
      transform: translateY(0) scale(0.98);
    }
    .back-link {
      text-align: center;
      margin-top: 16px;
    }
    .back-link a {
      color: #6b2b46;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
    }
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
  </style> <!-- end of internal css styles -->
</head> <!-- end of head section -->
<body> <!-- body element for page content -->
  <div class="forgot-container"> <!-- main container for forgot password page -->
    <!-- Animated background -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, #fff8fb 0%, #fffaf6 50%, #f8f9fa 100%); z-index: -2;"></div> <!-- background gradient layer -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 20%, rgba(255,107,157,0.15) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(78,205,196,0.12) 0%, transparent 50%), radial-gradient(circle at 40% 60%, rgba(177,156,217,0.1) 0%, transparent 50%); z-index: -1; animation: float 20s ease-in-out infinite;"></div> <!-- animated background orbs -->

    <div class="forgot-card"> <!-- card container for form elements -->
      <div class="forgot-header"> <!-- header section with icon and title -->
        <span class="forgot-icon">🔑</span> <!-- key icon for forgot password -->
        <h1 class="forgot-title">Forgot Password</h1> <!-- main heading -->
        <p class="forgot-subtitle">Enter your username to reset your password</p> <!-- subtitle instruction -->
      </div> <!-- end of header -->

      <?php if ($message): ?> <!-- conditional display of message if exists -->
        <div class="message <?php echo strpos($message, 'reset') !== false ? 'success-message' : 'error-message'; ?>"> <!-- message div with dynamic class -->
          <strong><?php echo strpos($message, 'reset') !== false ? '✅ Success' : '⚠️ Error'; ?></strong><br> <!-- dynamic icon and title -->
          <?php echo htmlspecialchars($message); ?> <!-- display sanitized message -->
        </div> <!-- end of message div -->
      <?php endif; ?> <!-- end of conditional -->

      <form method="post" action="forgot_password.php"> <!-- form for password reset submission -->
        <div class="form-group"> <!-- form group for username input -->
          <label for="username">Username</label> <!-- label for input -->
          <input type="text" id="username" name="username" placeholder="Enter your username" required> <!-- text input for username -->
        </div> <!-- end of form group -->

        <button type="submit" class="reset-btn">Reset Password 🔄</button> <!-- submit button -->
      </form> <!-- end of form -->

      <div class="back-link"> <!-- back link container -->
        <a href="login.php">← Back to Login</a> <!-- link to login page -->
      </div> <!-- end of back link -->
    </div> <!-- end of forgot card -->
  </div> <!-- end of forgot container -->

  <style> <!-- additional internal styles -->
    @keyframes float { <!-- keyframe animation for floating effect -->
      0%, 100% { transform: translateY(0px) rotate(0deg); } <!-- start and end state -->
      50% { transform: translateY(-10px) rotate(1deg); } <!-- middle state -->
    } <!-- end of keyframe -->
  </style> <!-- end of additional styles -->
</body> <!-- end of body -->
</html> <!-- end of html document -->
