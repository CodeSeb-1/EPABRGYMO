<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

$request = [
    'query' => "
        SELECT 
            dr.*, dt.doc_name 
        FROM 
            document_request dr
        INNER JOIN 
            document_type dt 
        ON 
            dr.doc_type_id = dt.doc_type_id",
    "bind" => "",
    "value" => [],
];




function display_request()
{
    global $request;

    displayAll($request, null, function ($row, $id) {
        echo "
            <tr>
                <td>{$row['request_name']}</td>
                <td>{$row['doc_name']}</td>
                <td>{$row['request_purpose']}</td>
                <td>{$row['request_date']}</td>
                <td>{$row['request_status']}</td>
                <td><a href='#' id='view'>View</a></td>
            </tr>
        ";
    });


}


// secretary_document_request_controller.php