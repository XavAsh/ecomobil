<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>
<body>
<div class="navbar">
    <a href="View/Login.php">Login</a>
    <a href="<?php echo isset($_SESSION['email']) ? 'View/Reserver.php' : 'View/Login.php'; ?>">Réserver</a>
</div>

<p><a href="/ECOMOBIL/index.php" ><img src="/ECOMOBIL/assets/IMG/back.png" alt="fleche arriere" style="width: 70px; height: 70px;"></a></p> <br/>
<h1>Formulaire de création de compte</h1><br/>
<?php
if (isset($_SESSION["insertClient"]) && $_SESSION["insertClient"] === 0) {
    echo "Le mail ". $_SESSION["Email"] ." déjà existant ";
}
if (isset($_SESSION["insertClient"]) && $_SESSION["insertClient"] === 1) {
    echo "Bienvenue chez EcoMobil ";
}
?>
<form action="/ECOMOBIL/index.php?action=AddClient" method="post">
    <h2>Inscription</h2>

    <label for="Email">Email</label>
    <input type="email" id="Email" name="Email" required>

    <label for="Nom">Nom</label>
    <input type="text" id="Nom" name="Nom" required>

    <label for="Prenom">Prénom</label>
    <input type="text" id="Prenom" name="Prenom" required>

    <label for="Mdp">Mot de passe</label>
    <input type="password" id="Mdp" name="Mdp" required minlength="8" maxlength="100">

    <input type="submit" value="Inscription"><br/><br/>
    <a href="/ECOMOBIL/View/Login.php" target="_blank">Login</a>

</form>
</body>
</html>



