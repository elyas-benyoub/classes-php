<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>Update</title>
</head>

<body>
    <main>
        <div class="card-sign">
            <h1>Modifier le profile</h1>
            <form class="form-sign" action="index.php?action=update" method="post">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" id="firstname" value="<?= $_SESSION['user']["firstname"] ?? null ?>" required>
                <label for="lastname">Nom</label>
                <input type="text" name="lastname" id="lastname" value="<?= $_SESSION['user']["lastname"] ?? null ?>" required>
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="<?= $_SESSION['user']["login"] ?? null ?>" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $_SESSION['user']["email"] ?? null ?>" required>
                <button type="submit">Modifier</button>
            </form>
            <form action="index.php" method="get">
                <button type="submit" name="action" value="connected">Annuler</button>
            </form>
            <p class="message"><?= $message ?></p>
        </div>
    </main>
</body>

</html>