<?php

class DbhModel
{
    private string $host ;//= 'db';
    private string $dbname ;//= 'vacation_portal_database';
    private string $username ;//= 'app_user';
    private string $password ;//= '12345';
    private mysqli $connection;

    public function __construct() {
        $env = parse_ini_file(__DIR__ . '/../../.env');

        $this->host = $env['DB_HOST'];
        $this->dbname = $env['DB_NAME'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASSWORD'];
        
    }

    protected function connect() : void
    {
        $this->connection  = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->connection ->connect_error) {
            die("Connection failed: " . $this->connection ->connect_error);
        }
    }

    protected function getConnection() : mysqli
    {
        return $this->connection;
    }

    protected function executeNonQuery(string $sql) : bool
    {
        $this->connect();
        $conn = $this->getConnection();
    
        try {
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                throw new Exception("MySQLi Error: " . $conn->error);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    

    protected function executeQuery(string $sql) : array
    {
        $this->connect();
        $result = $this->getConnection()->query($sql);
        $array = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array [] = $row;
            }
        }
        return $array ;
    }

    


}
?>