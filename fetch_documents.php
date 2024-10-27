<?php

header('Content-Type: application/json');
$jsonFile = 'documents.json';

if (file_exists($jsonFile)) {
    echo file_get_contents($jsonFile); 
} else {
    echo json_encode(['error' => 'File not found.']);
}
