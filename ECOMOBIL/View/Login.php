<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" type="text/css" href="/ECOMOBIL/assets/style.css">
</head>
<body>
<p><a href="/ECOMOBIL/index.php" ><img src="/ECOMOBIL/assets/IMG/back.png" alt="fleche arriere" style="width: 70px; height: 70px;"></a></p> <br/>
<h1>Formulaire de Connexion</h1>
<form action="/ECOMOBIL/index.php?action=login" method="POST">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Se Connecter"><br><br>

    <a href="/ECOMOBIL/View/AddClient.php" target="_blank">cree compte</a>

</form>
</body>
</html>
