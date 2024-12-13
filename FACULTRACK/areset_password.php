<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - FaculTrack</title>
    <link rel="icon" type="image/png" href="white.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(150deg, #f6f8f7, #43324f, #f6f8f7);
            color: #333;
        }

        .reset-password-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .reset-password-container h2 {
            font-size: 1.8em;
            color: #4b4b4b;
            margin-bottom: 20px;
        }

        .reset-password-container label {
            display: block;
            margin-bottom: 10px;
            color: #4b4b4b;
            font-weight: bold;
            text-align: left;
        }

        .reset-password-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .reset-password-container button {
            background-color: #ff7e5f;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .reset-password-container button:hover {
            background-color: #ff6a4d;
        }

        .reset-password-container a {
            color: #ff7e5f;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
        }

        .reset-password-container a:hover {
            text-decoration: underline;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="reset-password-container">
        <h2>Reset Password</h2>
        <?php
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            echo '<p class="success-message">Password has been reset successfully!</p>';
        } elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
            echo '<p class="error-message">There was an error resetting your password. Please try again.</p>';
        }
        ?>
        <form action="areset_password_action.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" required>
            <button type="submit">Reset Password</button>
        </form>
        <a href="adminlog.php">Back to Login</a>
    </div>
</body>
</html>
