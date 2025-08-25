<?php

$data = $user->update(
    $_POST['login'], 
    $_POST['email'], 
    $_POST['firstname'], 
    $_POST['lastname']
);

$_SESSION['user'] = $data['data'];

var_dump($data);
header('Location: index.php?action=connected');
exit;