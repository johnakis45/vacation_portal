<?php

class Dbh
{
    private $host = 'db'; // This is the service name of the database in docker-compose
    private $dbname = 'vacation_portal_database';
    private $username = 'app_user';
    private $password = '12345';

    private $connection;


    protected function connect()
    {
        $this->connection  = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->connection ->connect_error) {
            die("Connection failed: " . $this->connection ->connect_error);
        }
    }

    protected function getConnection()
    {
        return $this->connection;
    }

    protected function executeQueryInsert($sql)
    {
        $this->connect();
        if ($this->getConnection()->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    protected function executeQuery($sql)
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