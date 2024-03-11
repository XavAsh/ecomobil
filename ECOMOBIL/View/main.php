
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
    <title>Ecomobil - Welcome</title>
</head>
<body>

<div class="navbar">
    <span><?php echo ucfirst($_SESSION["Prenom"]); ?></span>
    <a href="index.php?action=Deconnexion">Déconnexion</a>
    <a href="<?php echo isset($_SESSION['email']) ? 'View/Reserver.php' : 'View/Login.php'; ?>">Réserver</a>
</div>

<div class="accueil">
    <h1>Welcome to Ecomobil!</h1>
    <?php if (isset($welcomeMessage)) { ?>
        <p><?php echo $welcomeMessage; ?></p>
    <?php } ?>
</div>
</body>
</html>
