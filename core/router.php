<?php

$message = $_SESSION['message'] ?? "";
unset($_SESSION['message']);

$user = new User($_SESSION['user'] ?? null);

// Gestion de l’affichage
if (isset($_GET['action'])) {
    $_SESSION['display'] = match ($_GET['action']) { 
        "connected" => "connected",
        "signup" => "signup",
        "update" => "update",
        default => "signin"
    };
}

// Deconnexion
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "logout":
            require_once BASE_PATH . "/controllers/LogoutController.php";
            return;
        case "delete":
            require_once BASE_PATH . "/controllers/DeleteController.php";
            return;
    }
}

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_SESSION['display']) {
        case 'signup':
            require_once BASE_PATH . "/controllers/RegisterController.php";
            return;
        case 'signin':
            require_once BASE_PATH . "/controllers/ConnectController.php";
            return;
        case 'update':
            require_once BASE_PATH . "/controllers/UpdateController.php";
    }
}

$connected = $user->isConnected();
echo $connected ? "<p>Vous êtes connectés.</p>"
    : "<p>Vous avez été déconectés.</p>";

// Rendu de la vue
switch ($_SESSION['display']) {
    case "signin":
        require_once BASE_PATH . "/views/signin.php";
        break;
    case "signup":
        require_once BASE_PATH . '/views/signup.php';
        break;
    case "connected":
        require_once BASE_PATH . '/views/dashboard.php';
        break;
    case "update":
        require_once BASE_PATH . '/views/update.php';
        return;
    default:
        echo "<p>Page inconnue</p>";
        break;
}
