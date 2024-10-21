<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EPABRGYMO/includes/model.php');

if(isset($_POST['report'])) {
    $report = $_POST['report'];
    $description = $_POST['description'];
    $person = $_POST['person'];

    $insert = [
        'query' => 'INSERT INTO reports'
    ];
}
