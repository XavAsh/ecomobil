<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Participants</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>

<body>
<div class="navbar">
    <span><?php echo ucfirst($_SESSION["Prenom"]); ?></span>
    <a href="/ECOMOBIL/index.php">Acceuil</a>
</div>
<p><a href="/ECOMOBIL/View/Reserver.php"><img src="/ECOMOBIL/assets/IMG/back.png" alt="fleche arriere" style="width: 70px; height: 70px;"></a></p> <br/>

<h2>Add Participants</h2>

<form action="/ECOMOBIL/View/ChoixV.php" method="post">
    <label for="user_name">Votre Nom:</label>
    <input type="text" id="user_name" name="user_name" value="<?php echo ucfirst($_SESSION["Nom"]); ?>" readonly>

    <label for="user_surname">Votre Prenom:</label>
    <input type="text" id="user_surname" name="user_surname" value="<?php echo ucfirst($_SESSION["Prenom"]); ?>" readonly><br/><br/>

    <?php
    $nbParticipants = isset($_SESSION['reservation']['nbParticipants']) ? (int)$_SESSION['reservation']['nbParticipants'] : 1;

    for ($i = 2; $i <= $nbParticipants; $i++) {
        ?>
        <label for="participant<?php echo $i; ?>">Participant <?php echo $i; ?> Nom:</label>
        <input type="text" id="participant<?php echo $i; ?>" name="participant<?php echo $i; ?>" required>

        <label for="surname<?php echo $i; ?>">Participant <?php echo $i; ?> Nom:</label>
        <input type="text" id="surname<?php echo $i; ?>" name="surname<?php echo $i; ?>" required>

        <br><br>
        <?php
    }
    ?>

    <input type="submit" value="Submit Participants">
</form>
</body>

</html>
