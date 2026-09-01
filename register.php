<?php

include "config/database.php";

$message = "";

if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password)
            VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {

        $message = "Registration Successful!";

    } else {

        $message = "Error: " . $conn->error;

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Registration</title>

</head>

<body>

    <h1>🛒 SmartMart Navigator</h1>

    <h2>Create Account</h2>

    <?php

    if ($message != "") {
        echo "<p><b>$message</b></p>";
    }

    ?>

    <form method="POST">

        <label>Name:</label>
        <br>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

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

        <button type="submit" name="register">
            Register
        </button>

    </form>

</body>

</html>