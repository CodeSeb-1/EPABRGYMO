<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_document_request_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css???">
    <link rel="stylesheet" href="../../assets/modal.css?">
</head>
<body>
    <?php include_once("../header.php"); ?>
    <div class="main-container">
        <?php
            include_once("sidebar.php");
            sidebar("request");
        ?>
        <main class="content">
            <div class="content home">
                <h1>Document Request</h1>
                <section class="events">
                    <form action="" method="GET">
                        <select name="status" onchange="this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $selectedStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Ready To Claim" <?= $selectedStatus === 'Ready To Claim' ? 'selected' : '' ?>>Ready to Claim</option>
                        </select>
                    </form><br>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Document Type</th>
                                <th>Purpose</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                display_request($filterStatus);     
                                ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Document Request Details</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_document_request_controller.php" method="POST">
            <input type="hidden" name="doc_req_id" id="doc_req_id" value="<?= $requestDetails['doc_req_id'] ?? '' ?>">
            <div id="modal-body" class="form-content">
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_name">Full Name:</label>
                        <span id="request_name"><?= $requestDetails['request_name'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Address:</label>
                        <span id="request_name"><?= $requestDetails['request_address'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Age:</label>
                        <span id="request_name"><?= $requestDetails['request_age'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="doc_type">Document Type:</label>
                        <span id="doc_type"><?= $requestDetails['doc_name'] ?? '' ?></span>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_purpose" class="<?=$statusClass?>">Purpose:</label>
                        <span id="request_purpose"><?= $requestDetails['request_purpose'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_date">Request Date:</label>
                        <span id="request_date"><?= $formattedDate ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_status">Status:</label>
                        <span id="request_status"><?= $requestDetails['request_status'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_status">Expiration Date:</label>
                        <span><input type="datetime-local" name="" id=""></span>
                    </div>
                </div>
            </div>
            <div class="form-actions" id="form-actions">
            <?php
                if ($requestDetails) {
                    if ($requestDetails['request_status'] === 'Approved') {
                        echo '<button type="submit" name="claim" class="btn btn-primary">Ready To Claim</button>';
                    } else if ($requestDetails['request_status'] === 'Pending') {
                        echo '<button type="submit" name="decline" class="btn btn-sec">Decline</button> ';
                        echo '<button type="submit" name="accept" class="btn btn-primary">Accept</button>';
                    }
                }
                ?>
            </div>
        </form>
    </div>
</div>
<script>
    var modal = document.getElementById("myModal");
    var span = document.getElementById("closeModal");

    <?php if ($requestDetails): ?>
        modal.style.display = "block";
    <?php endif; ?>

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>