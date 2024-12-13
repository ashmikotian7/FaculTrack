<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Sign Up - FaculTrack</title>
  <link rel="icon" type="image/png" href="white.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(150deg, #f6f8f7, #43324f, #f6f8f7);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .signup-container {
      width: 450px;
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .signup-container h2 {
      color: #2d3436;
      font-size: 1.8em;
      margin-bottom: 25px;
      letter-spacing: 1px;
    }

    .signup-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .signup-form input[type="text"],
    .signup-form input[type="email"],
    .signup-form input[type="password"],
    .signup-form input[type="date"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .signup-form input[type="text"]:focus,
    .signup-form input[type="email"]:focus,
    .signup-form input[type="password"]:focus,
    .signup-form input[type="date"]:focus {
      outline: none;
      border-color: #74b9ff;
      box-shadow: 0 0 8px rgba(116, 185, 255, 0.5);
    }

    .signup-form button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(45deg, #74b9ff, #0984e3);
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: transform 0.2s, background 0.3s;
    }

    .signup-form button:hover {
      background: linear-gradient(45deg, #0984e3, #74b9ff);
      transform: scale(1.03);
    }

    .response-message {
      display: none;
      margin-top: 20px;
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
    }

    .response-message.success {
      background: #55efc4;
      color: #2d3436;
    }

    .response-message.error {
      background: #d63031;
      color: #ffffff;
    }

    .login-link {
      margin-top: 20px;
      color: #0984e3;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    .login-link:hover {
      color: #74b9ff;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="signup-container">
    <h2>Faculty Sign Up</h2>
    <form class="signup-form" id="signupForm" action="faculty_signup.php" method="POST">
        <input type="text" name="facultyID" placeholder="Faculty ID" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address (only @sode-edu.in)" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="date" name="birthdate" placeholder="Birthdate" required>
        <input type="text" name="department" placeholder="Department" required>
        <button type="submit">Sign Up</button>
    </form>
    <div class="response-message" id="responseMessage"></div>
    <a href="faclogin.php" class="login-link">Already have an account? Login here</a>
  </div>

  <script>
    document.getElementById('signupForm').addEventListener('submit', function (event) {
      event.preventDefault();
      const emailInput = this.querySelector('input[name="email"]').value;

      if (!emailInput.endsWith("@sode-edu.in")) {
        const messageBox = document.getElementById('responseMessage');
        messageBox.style.display = 'block';
        messageBox.className = 'response-message error';
        messageBox.textContent = 'This platform is only for @sode-edu.in email addresses.';
        return;
      }

      const formData = new FormData(this);
      fetch('faculty_signup.php', {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(data => {
          const messageBox = document.getElementById('responseMessage');
          messageBox.style.display = 'block';
          messageBox.className = 'response-message ' + (data.status === 'success' ? 'success' : 'error');
          messageBox.textContent = data.message;
        })
        .catch(() => {
          const messageBox = document.getElementById('responseMessage');
          messageBox.style.display = 'block';
          messageBox.className = 'response-message error';
          messageBox.textContent = 'An unexpected error occurred.';
        });
    });
  </script>

</body>
</html>
