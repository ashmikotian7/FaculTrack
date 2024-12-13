<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - FaculTrack</title>
    <link rel="icon" type="image/png" href="white.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            color: #fff;
        }

        .forgot-password-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .forgot-password-container h2 {
            font-size: 1.8em;
            color: #4b4b4b;
            margin-bottom: 20px;
        }

        .forgot-password-container p {
            font-size: 0.9em;
            color: #6a6a6a;
            margin-bottom: 20px;
        }

        .forgot-password-container label {
            display: block;
            margin-bottom: 8px;
            color: #4b4b4b;
            font-weight: bold;
        }

        .forgot-password-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .forgot-password-container button {
            background-color: #2575fc;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            width: 100%;
        }

        .forgot-password-container button:hover {
            background-color: #0b5ed7;
        }

        .forgot-password-container a {
            color: #2575fc;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
        }

        .forgot-password-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h2>Forgot Password?</h2>
        <p>Please enter your registered email address to receive a password reset link.</p>
        <form action="aforgot_password_action.php" method="POST">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <button type="submit">Verification</button>
        </form>
        <a href="adminlog.php">Back to Login</a>
    </div>
</body>
</html>
