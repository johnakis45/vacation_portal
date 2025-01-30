<?php

//require_once '../config';
require_once 'Dbh.php';

class User extends Dbh
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $unique_code;
    private $role;


    public function __construct()
    {
    }

    public function insertUser()
    {
        //(username, user_code, password, email, role)
        $sql = "INSERT INTO users (username, user_code, password, email, role) VALUES ('$this->username', '$this->unique_code', '$this->password' ,'$this->email', '$this->role')";
        if ($this->connect()->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function deleteUser($id)
    {
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        $result = $this->executeQuery($sql);
        if(!empty($result)){
            $sql = "DELETE FROM vacations WHERE user_id = $id";
            $this->executeQueryInsert($sql);
        }
        $sql = "DELETE FROM users WHERE id = $id";
        $this->executeQueryInsert($sql);
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

    public function updateUser($id, $username, $email, $password)
    {
        $sql = "UPDATE users SET username = '$username', email = '$email', password = '$password' WHERE id = $id";
        $this->executeQueryInsert($sql);
    }

    public function loginUser($name, $password)
    {
        $this->connect();
        $this->username = $name; //why when i dont save it in these variables it does not work?
        $this->password = $password;
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            if ($this->passwordVerify($this->password, $row['password'])) {
                $this->role = $row['role'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        return false;

        $conn->close();
    }


    private function passwordHasher($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    private function passwordVerify($password, $hash)
    {
        return true;
        //return password_verify($password, $hash);
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