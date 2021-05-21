<?php

class Dbh
{   // Подключаем к БД
    public $conn;

    public function __construct($config)
    {
        $this->conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['dbname']);
        $this->conn->set_charset('utf8mb4');
    }
    public function preparedQuery($sql, $param)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s',$param);
        $stmt->execute();
        return $stmt;
    }

    public function selectResult($sql, $param = null)
    {
        if (!$param) {
            return $this->conn->query($sql);
        }
        return $this->preparedQuery($sql, $param)->get_result();
    }

    public function selectAll($sql, $param = null)
    {
        return $this->selectResult($sql, $param)->fetch_all(MYSQLI_ASSOC);
    }

    public function getCount()
    {   $row =  $this->selectResult('SELECT count(*) FROM positions')->fetch_all(MYSQLI_NUM);
        $quantity = $row[0][0];
        echo $quantity;
        return $quantity;
    }

    

    
}
