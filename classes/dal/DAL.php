<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/ConfigManager.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dal/database/Database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/message.php");
class DAL {
    private DAO $dao;
    public function __construct()
    {
        if (!$this->Init()) {
            // Todo: log error db connection failed
        }
    }

    public function Init()
    {
        // if connection  failed return false; else return true;
        $this->dao = new DAO(ConfigManager::$DatabaseHost, ConfigManager::$DatabaseUser, ConfigManager::$DatabasePsw, ConfigManager::$DatabaseScheme);
        $res = $this->dao->Connect();
        if ($res->ErrorId != 0) {
            return false;
        }
    }

    //region User Authentication
    public function Authentication(string $email, string $password): ?Message {
        // Sanitize Values
        if (empty($email)) return new Message(1000, "Invalid email address.");
        if (empty($password)) return new Message(1001, "Invalid password.");

        try {
            $query = $this->dao->Query("call usp_authenticate_user(:email, :password)", [
                ":email" => ($email),
                ":password" => ($password)
            ]);

            if ($query != null && $query->rowCount() > 0) {
                $rows = $query->fetch(PDO::FETCH_ASSOC);
                $this->dao->CloseCursor($query); // release resources

                if ($rows != null && $rows["Result"] > 0) {
                    return new Message(0, "ok", $rows);
                } else {
                    return new Message(1002, "Email or password is incorrect", $rows);
                }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

        return null;
    }

    public function CreateAccount(string $username, string $email, string $password): ?Message {
        // Sanitize Values
        if (empty($email)) return new Message(1000, "Invalid email address.");
        if (empty($password)) return new Message(1001, "Invalid password.");
        if (empty($username)) return new Message(1003, "Invalid Username");

        try {
            $query = $this->dao->Query("call usp_create_account(:username, :email, :password)", [
                ":username" => ($username),
                ":email" => ($email),
                ":password" => ($password)
            ]);

            if ($query != null && $query->rowCount() > 0) {
                $rows = $query->fetch(PDO::FETCH_ASSOC);
                $this->dao->CloseCursor($query); // release resources

                if ($rows != null && $rows["Result"] > 0) {
                    return new Message(0, "ok", $rows);
                } else {
                    return new Message(2000, $rows["Msg"], $rows);
                }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

        return null;
    }
    //endregion
}