<?php

require($_SERVER['DOCUMENT_ROOT'] . '/dbh.php');
require($_SERVER['DOCUMENT_ROOT'] . '/positions.php');

$config = require 'config.php';
$dbh = new Dbh($config);
$position = new Position($dbh);

switch ($_GET['action']) {
    case 'getpositions':
        $output = $position->getAllPositions();
        echo json_encode($output);
        break;
    case 'addposition':
        $content = $_GET['content'];
        $position->addPosition($content);
        break;
    case 'getsearchpositions':
        $content = $_GET['content'];
        $output = $position->searchPosition($content);
        echo json_encode($output);
        break;
    case 'deleteposition':
        $id = $_GET['id'];
        $position->deletePosition($id);
        break;
    default:
        header("HTTP/1.1 400 Bad Request");
}
