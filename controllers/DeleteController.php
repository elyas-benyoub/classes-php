<?php

if (isset($_SESSION['user'])) {
    $response = $user->delete();

    $_SESSION['message'] = $response['message'];

    header('Location: index.php');
    exit;
} else {
    $_SESSION['message'] = "Aucun utilisateur en session.";
    header('Location: index.php');
    exit;
}