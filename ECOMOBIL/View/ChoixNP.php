<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $surname = $_POST["surname"];

    $_SESSION["participant"] = array(
        "name" => $name,
        "surname" => $surname
    );

    header("Location: ChoixV.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
</head>
<body>
<h2>Enter Your Name and Surname</h2>

<form action="/ECOMOBIL/View/ChoixNP.php" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="surname">Surname:</label>
    <input type="text" name="surname" required>

    <input type="submit" value="Submit">
</form>
</body>
</html>
