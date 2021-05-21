<?php

class Position {
    protected $dbh;

    public function __construct(Dbh $dbh)
    {
        $this->dbh = $dbh;
    }
    // Получаем все позциии из БД и возвращаем их 
    public function getAllPositions()
    {
        return $this->dbh->selectAll('SELECT * FROM positions');
    }
    public function addPosition($content)
    {
        $count = $this->dbh->getCount();
        if ($count < 10) {
            $this->dbh->preparedQuery("INSERT INTO positions (content) VALUES (?)", $content);
        }
    }
    public function deletePosition($id)
    {
        $this->dbh->preparedQuery("DELETE FROM positions WHERE id = ?", $id);
    }
    //Поиск позиций в БД по столбцу content
    public function searchPosition($content)
    {
        $content = "%$content%";
        return $this->dbh->selectAll('SELECT * FROM positions WHERE content LIKE ?',$content);
    }
    

}