<?php

$valid = isset(
    $_POST["firstname"],
    $_POST["lastname"],
    $_POST["email"],
    $_POST["login"],
    $_POST["password"],
    $_POST["confirm"]
);

if (!$valid || in_array('', $_POST, true)) {
    $message = "Remplissez tous les champs.";
} elseif ($_POST["password"] !== $_POST["confirm"]) {
    $message = "Les mots de passe ne correspondent pas.";
} else {
    $user = new User();
    $data = $user->register(
            $_POST["login"],
            $_POST["password"],
            $_POST["email"],
            $_POST["firstname"],
            $_POST["lastname"]
    );
        
    if ($data["status"] === "success") {
        $_SESSION['user'] = $data['data'];
        $_SESSION['display'] = 'connected';
        $_SESSION['message'] = $data['message'];
    } else {
        $_SESSION['message'] = $data["message"];
    }
}

header('Location: ' . $_SERVER['PHP_SELF']);
exit;