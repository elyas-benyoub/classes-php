<!-- formulaire de connexion -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>Document</title>
</head>

<body>
    <main>
        <div class="card-sign">
            <h1>Se connecter</h1>
            <form class="form-sign" action="index.php" method="post">
                <label for="login">Login</label>
                <input type="login" name="login" id="login" value="<?= $_POST["login"] ?? null ?>" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Connexion</button>
            </form>
            <p class="message"><?= $message ?></p>
        </div>
        <form action="index.php" method="get">
            <button type="submit" name="action" value="signup">S'enregistrer</button>
        </form>
    </main>
</body>

</html>