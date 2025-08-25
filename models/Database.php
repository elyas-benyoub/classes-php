<?php

class DataBase {
    private static ?mysqli $connexion = null;

    public static function getConnexion() {
        if (self::$connexion === null) {
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                if ($_SERVER['HTTP_HOST'] === 'localhost:8888') {
                    self::$connexion = new mysqli("localhost", "root", "root", "classes");
                } else {
                    self::$connexion = new mysqli("localhost", "elyas-benyoub", "5Scbdpfttpmlr!", "elyas-benyoub_classes");
                }

                self::$connexion->set_charset("utf8mb4");

            } catch (mysqli_sql_exception $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$connexion;
    }
}
