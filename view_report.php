<?php
include_once("userController/report_controller.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet" href="assets/style1.css">
    <link rel="stylesheet" href="assets/pagination.css">
    <link rel="stylesheet" href="assets/modal.css">
    <link rel="stylesheet" href="assets/success-modal.css">
</head>

<body>
    <?php include_once("header.php"); nav("reports"); ?>

    <main>
        <div class="container" id="view-container">
            <section class="view-request">
                <div class="table" id="request">
                    <div class="head">
                        <div class="btn">
                            <a href="report.php">Back</a>
                        </div>
                    </div>

                    <h1>Your Reports</h1>

                    <form action="" method="GET">
                        <select name="status" onchange="this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="In Progress" <?= $selectedStatus === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="On Hold" <?= $selectedStatus === 'On Hold' ? 'selected' : '' ?>>On Hold</option>
                            <option value="Resolved" <?= $selectedStatus === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            <option value="Closed" <?= $selectedStatus === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="Canceled" <?= $selectedStatus === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            <option value="Declined" <?= $selectedStatus === 'Declined' ? 'selected' : '' ?>>Declined</option>
                        </select>
                    </form>

                    <br>

                    <table>
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Purok</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php display_reports(); ?>
                        </tbody>
                    </table>

                    <div class="pagination" id="pagination">
                        <span>Showing <?php echo $page; ?> of <?php echo $pages; ?></span>
                        <a href="?page=1&status=<?= urlencode($selectedStatus) ?>">First</a>
                        <a href="?page=<?= max(1, $page - 1) ?>&status=<?= urlencode($selectedStatus) ?>">Previous</a>

                        <div class="page-numbers">
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="?page=<?= $i ?>&status=<?= urlencode($selectedStatus) ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
                            <?php endfor; ?>
                        </div>

                        <a href="?page=<?= min($pages, $page + 1) ?>&status=<?= urlencode($selectedStatus) ?>">Next</a>
                        <a href="?page=<?= $pages ?>&status=<?= urlencode($selectedStatus) ?>">Last</a>
                    </div>
                </div>
            </section>
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