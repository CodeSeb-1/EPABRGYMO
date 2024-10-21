<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

if (isset($_POST['report'])) {
    $report_type = $_POST['report_type'];
    $report_content = $_POST['description'];
    $report_name = $_POST['person'];
    $report_purok = ($_POST['purokOption'] === "sameAsMe") ? $_SESSION['user_purok'] : $_POST['otherPurok'];
    $user_id = $_SESSION['user_id'];

    // Insert query configuration
    $insert_report = [
        'query' => "INSERT INTO reports (user_id, report_type, report_content, report_name, report_purok) 
                    VALUES (?, ?, ?, ?, ?)",
        'bind' => 'isssi',
        'value' => [$user_id, $report_type, $report_content, $report_name, $report_purok]
    ];

    // Execute the insertion
    $result = insertData($insert_report);

    // Handle success or failure
    if ($result) {
        echo "<script>alert('Report submitted successfully!'); window.location.href='../report.php';</script>";
    } else {
        echo "<script>alert('Error: Report could not be processed.'); window.location.href='../report.php';</script>";
    }
}
