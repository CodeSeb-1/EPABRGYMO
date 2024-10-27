<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EPABRGYMO/includes/model.php');

function getAllNotifications($user_id)
{
    $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
    $data = [
        'query' => $query,
        'bind' => 'i', // Integer
        'value' => [$user_id]
    ];
    return select($data);
}


function deleteNotification($notification_id)
{
    $query = "DELETE FROM notifications WHERE id = ?";
    $data = [
        'query' => $query,
        'bind' => 'i',
        'value' => [$notification_id]
    ];
    return deleteData($data);
}

function displayNotifications($user_id)
{
    $notifications = getAllNotifications($user_id);

    if (empty($notifications)) {
        return "<p>No notifications available.</p>";
    }

    $output = '';
    foreach ($notifications as $row) {
        $status = $row['is_read'] ? 'Read' : 'Unread';
        $fontWeight = $row['is_read'] ? 'normal' : 'bold';

        // Check if the link already has query parameters
        $link = htmlspecialchars($row['link']);
        $separator = (strpos($link, '?') !== false) ? '&' : '?';  // Use & if ? exists

        // Build the link with notification_id
        $fullLink = $link . $separator . "notification_id=" . $row['id'];

        $output .= "
            <a href='{$fullLink}' class='notification-link'>
                <div class='notification' style='font-weight: {$fontWeight};'>
                    <strong>{$row['type']}</strong> - {$row['message']}<br>
                    <small>Status: $status | {$row['created_at']}</small>
                </div>
            </a>
            <hr>";
    }
    return $output;
}




// Handle mark as read request
if (isset($_POST['mark_as_read'])) {
    markAsRead($_POST['notification_id']);
}

// Handle delete request
if (isset($_POST['delete'])) {
    deleteNotification($_POST['notification_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        

        .notification {
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

    

        button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[name="mark_as_read"] {
            background-color: #4CAF50;
            color: white;
        }

        button[name="delete"] {
            background-color: #f44336;
            color: white;
        }

        .notification-link {
            text-decoration: none;
            color: inherit;
            display: block;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            background-color: white;
            transition: background-color 0.2s;
        }

        .notification-link:hover {
            background-color: #f0f0f0;
        }

        .notification {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <link rel="stylesheet" href="assets/style1.css?">
</head>

<body>
<?php include_once("header.php");
nav("home") ?>

    <h1>Your Notifications</h1>


    <?= displayNotifications(2); ?>

</body>

</html>