<!-- Dashboard -->

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
        <h1>Bonjour <b><?= htmlspecialchars($_SESSION['user']['firstname']) ?></b></h1>
        <form action="index.php" method="get">
            <button type="submit" name="action" value="logout">Se déconnecter</button>
            <button type="submit" name="action" value="delete">Supprimer le compte</button>
            <button type="submit" name="action" value="update">Modifier le profil</button>
        </form>
    </main>
</body>

</html>