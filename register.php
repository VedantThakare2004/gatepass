<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Securely hash the password

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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

    /* Container for the form */
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

    /* Form input fields */
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

    /* Register button */
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

    /* Hover and active effects for button */
    .btn:hover {
      background: #1E5A21; /* Darker green on hover */
      transform: translateY(-3px); /* Slight lift effect */
    }

    .btn:active {
      transform: translateY(2px); /* Slight pressed effect */
    }

    /* Registration text */
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
    <h1>Register for College Gate Pass</h1>
  </header>

  <!-- Container with form for registration -->
  <div class="container">
    <form method="POST" action="register.php">
      <input type="text" name="name" placeholder="Name" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>
