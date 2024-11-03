<?php
include_once("userController/report_controller.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="assets/style1.css??????">
    <link rel="stylesheet" href="assets/pagination.css?">
    <link rel="stylesheet" href="assets/modal.css???">
    <link rel="stylesheet" href="assets/success-modal.css">
    <style>
        select#reason {
        width: 100%;
        background: transparent;
        outline: none;
        border: none;
        color: #2c3e50;
    }
    </style>
</head>

<body>
    <?php include_once("header.php");
    nav("reports") ?>
    <main>
        <div class="container" id="view-container">
            <section class="view-request">
                <div class="table" id="request">
                    <div class="head">
                        <div class="btn">
                            <a href="report.php">back</a>
                        </div>
                    </div>
                    <h1>Your Reports</h1>
                    <form action="" method="GET">
                        <select name="status" onchange="addRequestAnchor(); this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="In Progress" <?= $selectedStatus === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="On Hold" <?= $selectedStatus === 'Ready To Claim' ? 'selected' : '' ?>>On Hold
                            </option>
                            <option value="Resolved" <?= $selectedStatus === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            <option value="Closed" <?= $selectedStatus === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="Canceled" <?= $selectedStatus === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            <option value="Declined" <?= $selectedStatus === 'Declined' ? 'selected' : '' ?>>Declined</option>
                        </select>
                    </form>
                    <br>
                    <table >
                        <thead>
                            <tr>
                                <th>Report Type</th>
                                <th>Description</th>
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
                    <div class="pagination" id="pagination">
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
                </div> 
            </section>
            <div id="successModal" class="modal">
                <div class="modal-content success">
                    <div class="modal-header">
                        <h2>Success</h2>
                        <span class="close" onclick="closeSuccessModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>Your report has been successfully canceled!</p>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
    <div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Report Details</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form action="userController/report_controller.php" method="POST">
            <input type="hidden" name="report_id" id="report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <div id="modal-body" class="form-content">
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_name">Report Type:</label>
                        <span id="request_name"><?= $requestDetails['report_type'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Content:</label>
                        <span id="request_name"><?= $requestDetails['report_content'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_name">Person Involved: </label>
                        <span id="request_name"><?= $requestDetails['report_name'] ?? '' ?></span>
                    </div>
                </div>
                <div class="form-column">
                    <div class="form-group">
                        <label for="request_name">Purok: </label>
                        <span id="request_name"><?= $requestDetails['report_purok'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_date">Report Date:</label>
                        <span id="request_name"><?= $requestDetails['report_date'] ?? '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="request_status">Status:</label>
                        <span id="request_status"><?= $requestDetails['report_status'] ?? '' ?></span>
                    </div>
                    <?php
                        if($requestDetails['report_status'] === "On Hold" || $requestDetails['report_status'] === "Closed" || $requestDetails['report_status'] === "Declined") {
                            ?>
                            <div class="form-group">
                                <label for="expire_date">Reason:</label>
                                <span><?= $requestDetails['reason'] ?? '' ?></span>
                            </div>
                        
                        <?php
                           } else if($requestDetails['report_status'] === "Resolved") { ?>
                            <div class="form-group">
                                <label for="expire_date">Notes:</label>
                                <span><?= $requestDetails['reason'] ?? '' ?></span>
                            </div>
                        <?php        
                            } else if($requestDetails['report_status'] === "Ready To Claim" || $requestDetails['report_status'] === "Claimed") {
                            ?>
                            <div class="form-group">
                                <label for="issued_date">Duration:</label>
                                <span id="issued_date"><?= $duration?></span>
                            </div>
                        <?php
                        } else if ($requestDetails['report_status'] === "Canceled"|| $requestDetails['report_status'] === "Declined") {?>
                            <div class="form-group">
                                <label for="reason">
                                    <?= $requestDetails['report_status'] === "Canceled" ? "Reason for Cancellation" : "Reason for Request Denial"; ?>
                                </label>
                                <span><?= $requestDetails['reason'] ?? ''; ?></span>
                            </div>

                       <?php }
                    ?>
                </div>
            </div>
            <div class="form-actions" id="form-actions">
            <?php
                if ($requestDetails) {
                    if ($requestDetails['report_status'] === 'Pending') {
                        echo '<button type="submit" name="cancel" class="btn btn-primary">Submit</button> ';
                    }
                }
                ?>
            </div>
        </form>
    </div>
    <?php include_once("show-success-error-modal.php") ?>
    <?php include_once("show-modal.php"); ?>
    </main>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js??"></script>
    <script src="javascript/request.js"></script>
    <script src="javascript/other.js"></script>
    <script src="javascript/request-location.js"></script>
</body>

</html>