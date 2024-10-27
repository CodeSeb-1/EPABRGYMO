<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST['report'])) {
    $report_type = $_POST['report_type'];
    $report_content = $_POST['description'];
    $report_name = $_POST['person'];
    $report_purok = ($_POST['purokOption'] === "sameAsMe") ? $_SESSION['user_purok'] : $_POST['otherPurok'];
    $user_id = $_SESSION['user_id'];

    $insert_report = [
        'query' => "INSERT INTO reports (user_id, report_type, report_content, report_name, report_purok) 
                    VALUES (?, ?, ?, ?, ?)",
        'bind' => 'isssi',
        'value' => [$user_id, $report_type, $report_content, $report_name, $report_purok]
    ];

    $result = insertData($insert_report);

    if ($result) {
        $_SESSION['modal_btn'] = true;
        header("Location: ../report.php");
        exit;
    }
}
