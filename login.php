<?php

session_start();

include "config/database.php";

$message = "";

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users
            WHERE email = '$email'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "❌ Incorrect password";

        }

    } else {

        $message = "❌ User not found";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Login</title>

</head>

<body>

    <h1>🛒 SmartMart Navigator</h1>

    <h2>Login</h2>

    <?php

    if ($message != "") {
        echo "<p><b>$message</b></p>";
    }

    ?>

    <form method="POST">

        <label>Email:</label>
        <br>

        <input
            type="email"
            name="email"
            required
        >

        <br><br>

        <label>Password:</label>
        <br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <br>

    <a href="register.php">
        Create New Account
    </a>

</body>

</html>