<?php

require_once 'DbhModel.php';

class UserModel extends DbhModel
{
    // Properties
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $unique_code;
    private string $role;
    private DateTime $edit_date;

    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    // Getters
    public function getId(): ?int
    {
        return isset($this->id) ? $this->id : null;
    }
    
    public function getUsername(): ?string
    {
        return isset($this->username) ? $this->username : null;
    }
    
    public function getEmail(): ?string
    {
        return isset($this->email) ? $this->email : null;
    }
    
    public function getUniqueCode(): ?string
    {
        return isset($this->unique_code) ? $this->unique_code : null;
    }
    
    public function getRole(): ?string
    {
        return isset($this->role) ? $this->role : null;
    }
    
    public function getEditDate(): ?DateTime
    {
        return isset($this->edit_date) ? $this->edit_date : null;
    }
    

    // Setters
    public function setUsername(?string $username): void
    {
        if ($username !== null) {
            $this->username = $username;
        }
    }
    
    public function setEmail(?string $email): void
    {
        if ($email !== null) {
            $this->email = $email;
        }
    }
    
    public function setPassword(?string $password): void
    {
        if ($password !== null) {
            $this->password = $this->passwordHasher($password);
        }
    }
    
    public function setPasswordNoHash(?string $password): void
    {
        if ($password !== null) {
            $this->password = $password;
        }
    }
    
    public function setUniqueCode(?string $unique_code): void
    {
        if ($unique_code !== null) {
            $this->unique_code = $unique_code;
        }
    }
    
    public function setRole(?string $role): void
    {
        if ($role !== null) {
            $this->role = $role;
        }
    }
    

    // CRUD Operations
    public function insertUser(): bool
    {
        $sql = "INSERT INTO users (username, user_code, password, email, role) 
                VALUES ('$this->username', '$this->unique_code', '$this->password', '$this->email', '$this->role')";
        return $this->executeNonQuery($sql);
    }

    public function removeUser(int $id): void
    {
        $sql = "SELECT * FROM vacations WHERE user_id = $id";
        $result = $this->executeQuery($sql);
        if (!empty($result)) {
            $sql = "DELETE FROM vacations WHERE user_id = $id";
            $this->executeNonQuery($sql);
        }
        $sql = "DELETE FROM users WHERE id = $id";
        $this->executeNonQuery($sql);
    }

    public function fetchAllUsers(): array
    {
        $sql = "SELECT * FROM users WHERE role != 'manager'";
        return $this->executeQuery($sql);
    }

    public function fetchUserById(int $id): void
    {
        $sql = "SELECT * FROM users WHERE id = $id";
        $data = $this->executeQuery($sql);
        if (!empty($data)) {
            $this->initializeUserProperties($data[0]);
        }
    }

    public function fetchUserByUsername(string $username): void
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $data = $this->executeQuery($sql);
        if (!empty($data)) {
            $this->initializeUserProperties($data[0]);
        }
    }

    public function updateUser(int $id): bool
    {
        if ($this->password == null) {
            $sql = "UPDATE users SET username = '$this->username', email = '$this->email' WHERE id = $id";
        } else {
            $sql = "UPDATE users SET username = '$this->username', email = '$this->email', password = '$this->password' WHERE id = $id";
        }
        return $this->executeNonQuery($sql);
    }

    public function authenticateUser(string $password): bool
    {
        $this->fetchUserByUsername($this->username);
        if ( isset($this->password) && $this->passwordVerify($password, $this->password) ) {
            $this->password = "";
            return true;
        }
        return false;
    }

    // Helper Methods
    private function initializeUserProperties(array $user): void
    {
        $this->id = $user['id'];
        $this->username = $user['username'];
        $this->unique_code = $user['user_code'];
        $this->password = $user['password'];
        $this->email = $user['email'];
        $this->role = $user['role'];
        $this->edit_date = new DateTime($user['edit_date']);
    }

    private function passwordHasher(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

?>
