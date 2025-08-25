<?php

session_unset();
session_destroy();
$user = new User();
$user->disconnect();
header('Location: index.php?action=signin');
exit;
