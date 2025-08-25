<?php

require_once BASE_PATH . "/models/Database.php";

class User
{
    private mysqli $db;
    private $id = null;
    public $login = null;
    public $email = null;
    public $firstname = null;
    public $lastname = null;


    public function __construct(?array $data = null)
    {
        $this->db = DataBase::getConnexion();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->login = $data['login'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
        }
    }

    private function run_query(string $sql, string $types = "", array $params = [])
    {
        $stmt = $this->db->prepare($sql);

        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    public function isConnected(): bool
    {
        if (empty($this->id))
            return false;

        try {
            $query = "select id from utilisateurs where id = ?";
            $stmt = $this->run_query($query, "i", [$this->id]);
            $result = $stmt->get_result();

            return $result->num_rows === 1;
        } catch (mysqli_sql_exception $e) {
            return false;
        }

    }

    public function findUser(string $login, ?string $email)
    {
        try {
            $query = "select login, email from utilisateurs where email = ? or login = ?";
            $stmt = $this->run_query($query, "ss", [$email, $login]);
            $result = $stmt->get_result();
            return $result->num_rows > 0;
        } catch (mysqli_sql_exception $e) {
            echo "Erreur DB emailExists(): " . $e->getMessage();
            return false;
        }
    }

    public function getAllInfos()
    {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "email" => $this->email,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname
        ];
    }

    public function register($login, $password, $email, $firstname, $lastname)
    {
        if (empty($login) || empty($password) || empty($email) || empty($firstname) || empty($lastname)) {
            return [
                "status" => "error",
                "message" => "Veuillez remplir tous les champs."
            ];
        }

        if ($this->findUser($login, $email)) {
            return [
                "status" => "error",
                "message" => "Cette utilisateur existe déjà."
            ];
        }

        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->run_query(
                "insert into utilisateurs (login, password, email, firstname, lastname) values (?, ?, ?, ?, ?)",
                "sssss",
                [$login, $hashedPassword, $email, $firstname, $lastname]
            );

            if ($stmt) {
                $this->id = $this->db->insert_id;
                $this->login = $login;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;
            }

            return [
                "status" => "success",
                "message" => "Inscription réussie.",
                "data" => $this->getAllInfos()
            ];
        } catch (mysqli_sql_exception $e) {
            return [
                "status" => "error",
                "message" => "Erreur DB register(): " . $e->getMessage()
            ];
        }
    }

    public function connect(string $login, string $password)
    {
        try {
            $stmt = $this->run_query(
                "select * from utilisateurs where ? = login",
                "s",
                [$login]
            );
            $result = $stmt->get_result();
            $userData = $result->fetch_assoc();

            if (!$userData) {
                return [
                    "status" => "error",
                    "message" => "Utilisateur introuvable."
                ];
            }

            if (!password_verify($password, $userData['password'])) {
                return [
                    "status" => "error",
                    "message" => "Mot de passe incorrect."
                ];
            }

            $this->id = $userData['id'];
            $this->login = $userData['login'];
            $this->email = $userData['email'];
            $this->firstname = $userData['firstname'];
            $this->lastname = $userData['lastname'];

            return [
                "status" => "success",
                "message" => "Connexion réussie à $this->login.",
                "data" => $this->getAllInfos()
            ];
        } catch (mysqli_sql_exception $e) {
            return [
                "status" => "error",
                "message" => "Erreur DB connect(): " . $e->getMessage()
            ];
        }
    }

    public function disconnect()
    {
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;

        return [
            "status" => "success",
            "message" => "Vous avez été déconnecté"
        ];
    }

    public function delete()
    {
        try {
            $stmt = $this->db->prepare("delete from utilisateurs where login = ?");
            $stmt->bind_param("s", $this->login);
            if ($stmt->execute()) {
                $this->disconnect();

                return [
                    "status" => "success",
                    "message" => "Le profile à été supprimé."
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Échec de la suppression."
                ];
            }
        } catch (mysqli_sql_exception $e) {
            return [
                "status" => "error",
                "message" => "Erreur DB delete(): " . $e->getMessage()
            ];
        }
    }

    public function update($login, $email, $firstname, $lastname)
    {
        try {
            $stmt = $this->db->prepare(
                "
                update utilisateurs
                set login = ?,
                    email = ?,
                    firstname = ?,
                    lastname = ?
                where id = ?
                "
            );
            $stmt->bind_param("ssssi", $login, $email, $firstname, $lastname, $this->id);
            $stmt = $this->run_query(
                "
                update utilisateurs
                set login = ?,
                    email = ?,
                    firstname = ?,
                    lastname = ?
                where id = ?
                ",
                "ssssi",
                [$login, $email, $firstname, $lastname, $this->id]
            );

            if ($stmt->execute()) {
                $this->login = $login;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;
                return [
                    "status" => "success",
                    "message" => "Le profile à été modifié.",
                    "data" => $this->getAllInfos()
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Échec de la modification."
                ];
            }
        } catch (mysqli_sql_exception $e) {
            return [
                "status" => "error",
                "message" => "Erreur DB update(): " . $e->getMessage()
            ];
        }
    }
}