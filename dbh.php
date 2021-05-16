<?php

class Dbh
{
    private $hostname;
    private $username;
    private $password;
    private $dbname;

    // Соеднияемся с БД
    protected function  connect()
    {
        $this->hostname = 'localhost';
        $this->username = 'victor';
        $this->password = 'victor666';
        $this->dbname = 'positions';

        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            exit('Ошибка подключения к базе данных!');
        }
        return $conn;
    }
    // Получаем все позциии из БД и возвращаем их в массиве $output если записей больше нуля
    protected function getAllPositions()
    {
        $sql = 'SELECT * FROM positions';
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = $row;
            }
            return $output;
        }
    }
    //Добавляем позицию,метод принимает текст позиции(content) как аргумент
    protected function addPosition($content)
    {
        $sql = 'SELECT * FROM positions';
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows <= 10) {
            $sql = "INSERT INTO positions VALUES ('','$content')";
            $this->connect()->query($sql);
        }
    }
    //Удаляем позицию из БД,метод принимает id позиции(id) как аргумент
    protected function deletePosition($id)
    {
        $sql = "DELETE FROM positions WHERE id = '$id'";
        $this->connect()->query($sql);
    }
    //Поиск позиций в БД по столбцу content
    protected function searchPosition($content)
    {
        $sql = "SELECT * FROM positions WHERE content LIKE '%$content%'";
        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = $row;
            }
            return $output;
        }
    }
}
