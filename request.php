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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link rel="stylesheet" href="assets/style1.css???">
    <link rel="stylesheet" href="assets/pagination.css???">
</head>

<body>
    <?php include_once("header.php");
    nav("request") ?>
    <main>
        <div class="container">
            <section class="form">
                <h1>Document Request Form</h1>
                <div class="form-content">
                    <form action="userController/request_controller.php" method="POST">

                        <div class="form-group">
                            <label>Who is requesting the document?</label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="requestor" value="me" checked onchange="toggleRequestor()"
                                        required> Me
                                </label>
                                <label>
                                    <input type="radio" name="requestor" value="other" onchange="toggleRequestor()"
                                        required> Other
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="meRequestor">
                            <label>Requestor Name:</label>
                            <input type="text" name="originalUser" value="<?php echo $_SESSION['user_fullname']; ?>"
                                readonly>
                        </div>

                        <div id="otherRequestorDetails" style="display: none;">
                            <div class="form-group">
                                <label for="otherName">Requestor Name:</label>
                                <input type="text" id="otherName" name="otherName" placeholder="Enter full name">
                            </div>
                            <div class="form-group">
                                <label for="otherBirthday">Requestor Birthday:</label>
                                <input type="date" id="otherBirthday" name="otherBirthday" placeholder="Enter birthday">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <div class="radio-group">
                                    <label>
                                        <input type="radio" name="addressOption" value="sameAsMe" checked
                                            onchange="toggleAddressInput()"> Same as my address
                                    </label>
                                    <label>
                                        <input type="radio" name="addressOption" value="manual"
                                            onchange="toggleAddressInput()"> Enter manually
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="manualAddressInput" style="display: none;">
                                <label for="otherAddress">Requestor Address:</label>
                                <input type="text" id="otherAddress" name="otherAddress" placeholder="Enter address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="documentType">Select a document to request:</label>
                            <select name="documentId" id="documentId" required>
                                <option value="">Select document type</option>
                                <?php display_document(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="purpose">Purpose:</label>
                            <select name="purpose" id="purpose" required onchange="toggleOtherpurpose(this.value)">
                                <option value="">Select purpose</option>
                                <option value="Scholarship">Scholarship</option>
                                <option value="Financial Assistance">Financial Assistance</option>
                                <option value="Work Related">Work Related</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group" id="otherPurpose" style="display: none;">
                            <label for="otherPurpose">Other Purpose:</label>
                            <input type="text" id="other_Purpose" name="other_Purpose" placeholder="Enter purpose">
                        </div>

                        <input type="submit" name="request" value="Submit Request">
                    </form>
                </div>
            </section>
        </div>

            <section class="view-request">
                <div class="table" id="request">
                    <h1>Request</h1>
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
                    <div class="pagination">
                        <span>Showing <?php echo $page ?> of <?php echo $pages; ?></span>
                        <a href="?page=1#request">First</a>
                        <a href="?page=<?= max(1, $page - 1) ?>#request">Previous</a>
                    
                        <div class="page-numbers">
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="?page=<?= $i ?>#request" <?= ($i == $page) ? 'class="active"' : '' ?>><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                    
                        <a href="?page=<?= min($pages, $page + 1) ?>#request">Next</a>
                        <a href="?page=<?= $pages ?>#request">Last</a>
                    </div>

                </div> 
            </section>
    </main>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js"></script>
    <script src="javascript/request.js"></script>
    <script src="javascript/other.js"></script>
    <script>
    function addRequestAnchor() {
        if (!window.location.href.includes('#request')) {
            window.location.href += '#request';
        }
    }
</script>
</body>

</html>