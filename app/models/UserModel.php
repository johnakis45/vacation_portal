<?php

require_once 'DbhModel.php';

/**
 * UserModel Class
 * 
 * This class handles user-related operations, such as creating, updating, deleting, and authenticating users.
 * It extends from `DbhModel` to interact with the database.
 * @package app\models
 */
class UserModel extends DbhModel
{
    // Properties
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private string $unique_code;   
    private string $role;          // The role of the user (e.g., 'admin', 'employee')
    private DateTime $edit_date;   

    /**
     * Constructor to initialize the user model.
     * 
     * This constructor initializes the `DbhModel` and prepares the user data.
     */
    public function __construct()
    {
        parent::__construct();
    }

    // Getters
    /**
     * Get the ID of the user.
     *
     * @return int|null Returns the user ID or null if not set.
     */
    public function getId(): ?int
    {
        return isset($this->id) ? $this->id : null;
    }
    
    /**
     * Get the username of the user.
     *
     * @return string|null Returns the username or null if not set.
     */
    public function getUsername(): ?string
    {
        return isset($this->username) ? $this->username : null;
    }
    
    /**
     * Get the email of the user.
     *
     * @return string|null Returns the email or null if not set.
     */
    public function getEmail(): ?string
    {
        return isset($this->email) ? $this->email : null;
    }
    
    /**
     * Get the unique code of the user.
     *
     * @return string|null Returns the unique code or null if not set.
     */
    public function getUniqueCode(): ?string
    {
        return isset($this->unique_code) ? $this->unique_code : null;
    }
    
    /**
     * Get the role of the user.
     *
     * @return string|null Returns the role (e.g., 'admin', 'employee') or null if not set.
     */
    public function getRole(): ?string
    {
        return isset($this->role) ? $this->role : null;
    }
    
    /**
     * Get the date when the user was last edited.
     *
     * @return DateTime|null Returns the edit date or null if not set.
     */
    public function getEditDate(): ?DateTime
    {
        return isset($this->edit_date) ? $this->edit_date : null;
    }

    // Setters
    /**
     * Set the username of the user.
     *
     * @param string|null $username The username.
     */
    public function setUsername(?string $username): void
    {
        if ($username !== null) {
            $this->username = $username;
        }
    }
    
    /**
     * Set the email of the user.
     *
     * @param string|null $email The email address.
     */
    public function setEmail(?string $email): void
    {
        if ($email !== null) {
            $this->email = $email;
        }
    }
    
    /**
     * Set the password for the user (hashed).
     *
     * @param string|null $password The plain password to be hashed.
     */
    public function setPassword(?string $password): void
    {
        if ($password !== null) {
            $this->password = $this->passwordHasher($password);
        }
    }
    
    /**
     * Set the password for the user without hashing.
     *
     * @param string|null $password The plain password.
     */
    public function setPasswordNoHash(?string $password): void
    {
        if ($password !== null) {
            $this->password = $password;
        }
    }
    
    /**
     * Set the unique code for the user.
     *
     * @param string|null $unique_code The unique code assigned to the user.
     */
    public function setUniqueCode(?string $unique_code): void
    {
        if ($unique_code !== null) {
            $this->unique_code = $unique_code;
        }
    }
    
    /**
     * Set the role for the user (e.g., 'admin', 'employee').
     *
     * @param string|null $role The role of the user.
     */
    public function setRole(?string $role): void
    {
        if ($role !== null) {
            $this->role = $role;
        }
    }

    // CRUD Operations
    /**
     * Insert a new user into the database.
     * 
     * This method inserts a new user into the `users` table with their username, unique code, password, email, and role.
     *
     * @return bool Returns true if the insertion is successful, false otherwise.
     */
    public function insertUser(): bool
    {
        $sql = "INSERT INTO users (username, user_code, password, email, role) 
                VALUES ('$this->username', '$this->unique_code', '$this->password', '$this->email', '$this->role')";
        return $this->executeNonQuery($sql);
    }

    /**
     * Remove a user from the database.
     * 
     * This method deletes the user from the `users` table and removes their associated vacation requests.
     *
     * @param int $id The user ID to delete.
     */
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

    /**
     * Fetch all users (excluding managers) from the database.
     * 
     * This method retrieves all users except those with the 'manager' role.
     *
     * @return array An array of users.
     */
    public function fetchAllUsers(): array
    {
        $sql = "SELECT * FROM users WHERE role != 'manager'";
        return $this->executeQuery($sql);
    }

    /**
     * Fetch a user by their ID from the database.
     * 
     * This method retrieves the user details using the provided user ID.
     *
     * @param int $id The user ID.
     */
    public function fetchUserById(int $id): void
    {
        $sql = "SELECT * FROM users WHERE id = $id";
        $data = $this->executeQuery($sql);
        if (!empty($data)) {
            $this->initializeUserProperties($data[0]);
        }
    }

    /**
     * Fetch a user by their username from the database.
     * 
     * This method retrieves the user details using the provided username.
     *
     * @param string $username The username.
     */
    public function fetchUserByUsername(string $username): void
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $data = $this->executeQuery($sql);
        if (!empty($data)) {
            $this->initializeUserProperties($data[0]);
        }
    }

    /**
     * Update user details.
     * 
     * This method updates the user's information in the `users` table. If the password is provided, it will be updated as well.
     *
     * @param int $id The user ID.
     * @return bool Returns true if the update is successful, false otherwise.
     */
    public function updateUser(int $id): bool
    {
        if ($this->password == null) {
            $sql = "UPDATE users SET username = '$this->username', email = '$this->email' WHERE id = $id";
        } else {
            $sql = "UPDATE users SET username = '$this->username', email = '$this->email', password = '$this->password' WHERE id = $id";
        }
        return $this->executeNonQuery($sql);
    }

    /**
     * Authenticate a user based on their password.
     * 
     * This method checks if the provided password matches the stored hashed password for the user.
     *
     * @param string $password The plain password to verify.
     * @return bool Returns true if the password is valid, false otherwise.
     */
    public function authenticateUser(string $password): bool
    {
        $this->fetchUserByUsername($this->username);
        if (isset($this->password) && $this->passwordVerify($password, $this->password)) {
            $this->password = ""; // Clear the password after successful authentication
            return true;
        }
        return false;
    }

    // Helper Methods
    /**
     * Initialize the user properties from the fetched data.
     * 
     * This method sets the user's properties based on the provided data array.
     *
     * @param array $user The user data from the database.
     */
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

    /**
     * Hash the provided password.
     * 
     * This method hashes a plain password using the `PASSWORD_DEFAULT` algorithm.
     *
     * @param string $password The plain password.
     * @return string The hashed password.
     */
    private function passwordHasher(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the provided password against the hashed password.
     * 
     * This method verifies whether a plain password matches a hashed password.
     *
     * @param string $password The plain password.
     * @param string $hash The hashed password.
     * @return bool Returns true if the password is valid, false otherwise.
     */
    private function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

?>
