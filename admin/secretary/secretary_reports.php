<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_reports_controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css??">
    <link rel="stylesheet" href="../../assets/modal.css?">
    <link rel="stylesheet" href="../../assets/pagination.css?">
</head>
<body>
    <?php include_once("../header.php"); ?>
    <div class="main-container">
        <?php
            include_once("sidebar.php");
            sidebar("reports");
        ?>
        <main class="content">
            <div class="content home">
                <h1>Reports</h1><br>
                <section class="events">
                    <form action="" method="GET">
                        <select name="status" onchange="this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $selectedStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Canceled" <?= $selectedStatus === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            <option value="Declined" <?= $selectedStatus === 'Declined' ? 'selected' : '' ?>>Declined</option>
                            
                        </select>
                    </form><br>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Report Type</th>
                                <th>Content</th>
                                <th>Purok</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                display_reports();     
                                ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <span>Showing <?php echo $page; ?> of <?php echo $pages; ?></span>
                        <a href="?page=1&status=<?= urlencode($selectedStatus) ?>#request">First</a>
                        <a href="?page=<?= max(1, $page - 1) ?>&status=<?= urlencode($selectedStatus) ?>#request">Previous</a>
                    
                        <div class="page-numbers">
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="?page=<?= $i ?>&status=<?= urlencode($selectedStatus) ?>#request" <?= ($i == $page) ? 'class="active"' : '' ?>><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                    
                        <a href="?page=<?= min($pages, $page + 1) ?>&status=<?= urlencode($selectedStatus) ?>#request">Next</a>
                        <a href="?page=<?= $pages ?>&status=<?= urlencode($selectedStatus) ?>#request">Last</a>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Report Details</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_document_request_controller.php" method="POST">
            <input type="hidden" name="doc_req_id" id="doc_req_id" value="<?= $requestDetails['doc_req_id'] ?? '' ?>">
            <div id="modal-body" class="form-content">
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_name">Full Name:</label>
                        <span id="request_name"><?= $requestDetails['full_name'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Report Type:</label>
                        <span id="request_name"><?= $requestDetails['report_type'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Description:</label>
                        <span id="request_name"><?= $requestDetails['report_content'] ?? '' ?></span>
                    </div>

                    <?php
                        if(!empty($requestDetails['report_name'])) {?>
                            <div class="form-group">
                                <label for="doc_type">Person Involved:</label>
                                <span id="doc_type"><?= $requestDetails['report_name'] ?? '' ?></span>
                            </div>
                        <?php
                        }
                    ?>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_purpose" class="<?=$statusClass?>">Purok:</label>
                        <span id="request_purpose"><?= $requestDetails['report_purok'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_date">Reported Date:</label>
                        <span id="request_date"><?= $formattedDate ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_status">Status:</label>
                        <span id="request_status"><?= $requestDetails['report_status'] ?? '' ?></span>
                    </div>
                    <?php
                        if($requestDetails['report_status'] === "Approved") {
                            ?>
                            <div class="form-group">
                                <label for="expire_date">Expiration Date:</label>
                                <span><input type="date" name="expire_date" id="expire_date" required></span>
                            </div>
                        
                        <?php
                        }
                   
                        else if($requestDetails['report_status'] === "Ready To Claim" || $requestDetails['report_status'] === "Claimed") {
                            ?>
                            <div class="form-group">
                                <label for="issued_date">Duration:</label>
                                <span id="issued_date"><?= $duration?></span>
                            </div>
                        <?php
                        }
                    ?>
                </div>
            </div>
            <div class="form-actions" id="form-actions">
            <?php
                if ($requestDetails) {
                    if ($requestDetails['report_status'] === 'Approved') {
                        echo '<button type="submit" name="claim" class="btn btn-primary">Ready To Claim</button>';
                    } else if ($requestDetails['report_status'] === 'Pending') {
                        echo '<button type="submit" name="decline" class="btn btn-sec">Decline</button> ';
                        echo '<button type="submit" name="accept" class="btn btn-primary">Accept</button>';
                    }else if ($requestDetails['report_status'] === 'Ready To Claim') {
                        echo '<button type="submit" name="claimed" class="btn btn-primary">Claimed</button>';
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