<!-- formulaire de creation de compte -->
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
            <h1>S'enregistrer</h1>
            <form class="form-sign" action="index.php?action=signup" method="post">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" id="firstname" value="<?= $_POST["firstname"] ?? null ?>" required>
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" id="lastname" value="<?= $_POST["lastname"] ?? null ?>" required>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="<?= $_POST["login"] ?? null ?>" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $_POST["email"] ?? null ?>" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
                <label for="confirm">Confirmez</label>
                <input type="password" name="confirm" id="confirm" required>
                <button type="submit">S'enregistrer</button>
            </form>
            <p class="message"><?= $message ?></p>
        </div>
        <form action="index.php" method="get">
            <button type="submit" name="action" value="signin">Se connecter</button>
        </form>
    </main>
</body>

</html>