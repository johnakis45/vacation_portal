<?php

//require_once '../config';
require_once 'DbhModel.php';

class UserModel extends DbhModel
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $unique_code;
    private $role;


    public function __construct()
    {
        parent::__construct();
    }

    public function insertUser()
    {
        $sql = "INSERT INTO users (username, user_code, password, email, role) VALUES ('$this->username', '$this->unique_code', '$this->password' ,'$this->email', '$this->role')";
        return $this->executeNonQuery($sql);
    }

    public function removeUser($id)
    {
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        $result = $this->executeQuery($sql);
        if(!empty($result)){
            $sql = "DELETE FROM vacations WHERE user_id = $id";
            $this->executeNonQuery($sql);
        }
        $sql = "DELETE FROM users WHERE id = $id";
        $this->executeNonQuery($sql);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users WHERE role != 'manager'";
        return $this->executeQuery($sql);
        return $users;
    }

    public function getUser($id){
        $sql = "SELECT * FROM users WHERE id = $id";
        return $this->executeQuery($sql);
    }

    public function updateUser($id)
    {
        $sql = "UPDATE users SET username = '$this->username', email = '$this->email', password = '$this->password' WHERE id = $id";
        return $this->executeNonQuery($sql);
    }

    public function authenticateUser($password)
    {
        $result = $this->executeQuery("SELECT * FROM users WHERE username = '$this->username'");
        if (!empty($result) && isset($result[0])) {
            $row = $result[0]; 
            $this->id = $row['id'];
            if ($this->passwordVerify($password, $row['password'])) {
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }


    private function passwordHasher($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    private function passwordVerify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    //setters
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $this->passwordHasher($password);
    }

    public function setPasswordNoHash($password)
    {
        $this->password = $password;
    }

    public function setUniqueCode($unique_code)
    {
        $this->unique_code = $unique_code;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }


    //getters
    public function getId()
    {
        return $this->id;
    }   

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUniqueCode()
    {
        return $this->unique_code;
    }

    public function getRole()
    {
        return $this->role;
    }
    
}

?>