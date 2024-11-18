<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstname, lastname , email , password) VALUES ('$firstname','$lastname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Airport Ticket System</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="container">
    <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <form action="" method="post">
            <label for="firstname"><b>First Name</b></label>
            <input type="text" placeholder="Enter your first name" name="firstname" required>

            <label for="ln"><b>Last Name</b></label>
            <input type="text" placeholder="Enter your last name" name="lastname" required>

            <label for="em"><b>Email</b></label>
            <input type="email" placeholder="Enter your email" name="email" required><br><br>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter your password" maxlength="10" name="password" required>

            <p>Already have an account? <a href="login.php" style="color:dodgerblue">Log In</a>.</p>

            <div class="clearfix">
                <button type="reset" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn"  >Sign Up</button>
            </div>
    </div>
</form>
</div>
</body>
</html>
