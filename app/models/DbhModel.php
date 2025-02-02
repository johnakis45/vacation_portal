<?php

namespace App\models;

/**
 * Database Handler Model (DbhModel)
 * 
 * This class handles the database connection and query execution. It provides methods to connect to the 
 * database, execute SQL queries (both select and non-select), and retrieve the results as arrays.
 * It uses MySQLi to interact with the database.
 * @package app\models
 */
class DbhModel
{
    private string $host;      // Database host
    private string $dbname;    // Database name
    private string $username;  // Database username
    private string $password;  // Database password
    private \mysqli $connection; // MySQL connection instance

    /**
     * Constructor to initialize the database connection details from an .env file.
     * 
     * This constructor reads the database connection details (host, dbname, username, password) from an 
     * .env file located two directories above the current file. This allows for flexible configuration.
     */
    public function __construct()
    {
        $env = parse_ini_file(__DIR__ . '/../../.env');

        $this->host = $env['DB_HOST'];
        $this->dbname = $env['DB_NAME'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
    }

    /**
     * Establishes a connection to the MySQL database.
     * 
     * This method connects to the MySQL database using the connection details provided by the class properties.
     * If the connection fails, it stops execution and displays an error message.
     *
     * @return void
     */
    protected function connect(): void
    {
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * Returns the current database connection instance.
     * 
     * This method retrieves the active MySQLi connection instance to be used in query execution.
     * 
     * @return \mysqli The MySQLi connection instance.
     */
    protected function getConnection(): \mysqli
    {
        return $this->connection;
    }

    /**
     * Executes a non-query SQL command (e.g., INSERT, UPDATE, DELETE).
     * 
     * This method executes a SQL statement that does not return any rows (such as an INSERT, UPDATE, or DELETE).
     * It returns true if the query was successful, and false if there was an error.
     *
     * @param string $sql The SQL query to execute.
     * @return bool Returns true if the query was successful, false if an error occurred.
     */
    protected function executeNonQuery(string $sql): bool
    {
        $this->connect();
        $conn = $this->getConnection();
    
        try {
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                throw new \Exception("MySQLi Error: " . $conn->error);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Executes a SQL query and returns the result as an array of associative arrays.
     * 
     * This method executes a SQL SELECT query and fetches the results as an array. Each row of the result set
     * is returned as an associative array. The method returns an empty array if no results are found.
     * 
     * @param string $sql The SQL query to execute.
     * @return array An array of associative arrays containing the query results.
     */
    protected function executeQuery(string $sql): array
    {
        $this->connect();
        $result = $this->getConnection()->query($sql);
        $array = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        
        return $array;
    }
}

?>
