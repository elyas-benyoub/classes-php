<?php

$valid = isset(
    $_POST['login'],
    $_POST['password']
);

if (!$valid || in_array('', $_POST, true)) {
    $message = "Remplissez tous les champs.";
} else {
    $user = new User();
    $data = $user->connect($_POST['login'], $_POST['password']);

    if ($data["status"] === "success") {
        $_SESSION['user'] = $data['data'];
        $_SESSION['display'] = 'connected';
        $_SESSION['message'] = $data['message'];
    } else {
        $_SESSION['message']= $data["message"];
        $_SESSION['user'] = $data['data'];
    }
}

header('Location: ' . $_SERVER['PHP_SELF']);
exit;
