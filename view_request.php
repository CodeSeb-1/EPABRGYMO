<?php
include_once("userController/request_controller.php");
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
</head>

<body>
    <?php include_once("header.php");
    nav("request") ?>
    <main>
        <div class="container" id="view-container">
            <section class="view-request">
                <div class="table" id="request">
                    <div class="head">
                        <div class="btn">
                            <a href="request.php">back</a>
                        </div>
                    </div>
                    <h1>Your document requests</h1>
                    <form action="" method="GET">
                        <select name="status" onchange="addRequestAnchor(); this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $selectedStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Ready To Claim" <?= $selectedStatus === 'Ready To Claim' ? 'selected' : '' ?>>Ready to Claim
                            </option>
                            <option value="Claimed" <?= $selectedStatus === 'Claimed' ? 'selected' : '' ?>>Claimed</option>
                            <option value="Canceled" <?= $selectedStatus === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            <option value="Declined" <?= $selectedStatus === 'Declined' ? 'selected' : '' ?>>Declined</option>
                        </select>
                    </form>
                    <br>
                    <table >
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Document</th>
                                <th>Purpose</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include_once('userController/request_controller.php');
                                display_request();
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
                        <p>Your request has been successfully canceled!</p>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
    <?php include_once("show-success-error-modal.php") ?>
    <?php include_once("modal.php"); ?>
    <?php include_once("show-modal.php"); ?>
    </main>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js??"></script>
    <script src="javascript/request.js"></script>
    <script src="javascript/other.js"></script>
    <script src="javascript/request-location.js"></script>
</body>

</html>