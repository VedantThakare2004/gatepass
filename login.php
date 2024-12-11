<?php
session_start(); // Start a session to track the user

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a statement to fetch the user by email
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_password);

    if ($stmt->fetch()) {
        // Verify the entered password with the stored hash
        if (password_verify($password, $hashed_password)) {
            // Successful login, create a session for the user
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;

            // Redirect to dashboard
            header("Location: dashboard.html");
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #6e7ff3, #6e7ff3); /* Green gradient */
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      flex-direction: column;
    }

    header {
      text-align: center;
      margin-bottom: 30px;
    }

    h1 {
      font-size: 2.5rem;
      color: white;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }

    /* Landing Container */
    .container {
      background: rgba(255, 255, 255, 0.9); /* Light transparent background */
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      text-align: center;
      animation: slideIn 1s ease-out;
    }

    .container form {
      margin-bottom: 20px;
    }

    .container input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      box-sizing: border-box;
    }

    .container input:focus {
      border-color: #2E7D32; /* Focus border */
      outline: none;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #2E7D32;
      color: white;
      font-size: 1.2rem;
      font-weight: 600;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn:hover {
      background: #1E5A21; /* Darker green on hover */
      transform: translateY(-3px); /* Slight lift effect */
    }

    .btn:active {
      transform: translateY(2px); /* Slight pressed effect */
    }

    .container p {
      font-size: 1rem;
      margin-top: 20px;
      color: #333;
    }

    .container a {
      color: #2E7D32;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .container a:hover {
      color: #1E5A21;
    }

    /* Animation for form container */
    @keyframes slideIn {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .container {
        padding: 20px;
        width: 90%;
      }

      h1 {
        font-size: 2rem;
      }

      .container input {
        font-size: 0.9rem;
      }

      .btn {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Login to College Gate Pass</h1>
  </header>

  <!-- Container with form for login -->
  <div class="container">
    <form method="POST" action="login.php">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" class="btn">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
