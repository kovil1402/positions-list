<?php

require($_SERVER['DOCUMENT_ROOT'] . '/dbh.php');

class Handler extends Dbh
{
    function __construct()
    {
        $this->getAction();
    }
    // Получаем get-параметр action чтобы понять что делать с запросом
    public function getAction()
    {
        if ($_GET['action'] == '') {
            header("HTTP/1.0 400 Bad Request");
            die;
        } else if ($_GET['action'] == 'getpositions') {
            $output = $this->getAllPositions();
            echo json_encode($output);
        } else if ($_GET['action'] == 'addposition') {
            $content = $_GET['content'];
            $this->addPosition($content);
        } else if ($_GET['action'] == 'getsearchpositions') {
            $content = $_GET['content'];
            $output = $this->searchPosition($content);
            echo json_encode($output);
        } else if ($_GET['action'] == 'deleteposition') {
            $id = $_GET['id'];
            $this->deletePosition($id);
        }
    }
}
$handler = new Handler;
