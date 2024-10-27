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
    <link rel="stylesheet" href="../../assets/event-calendar.css??">
    <link rel="stylesheet" href="../../assets/modal.css?">
    <link rel="stylesheet" href="../../assets/pagination.css?">
    <style>
        #declineModal {
    z-index: 1001; /* Make it higher than myModal */
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 50%;
}

.close {
    float: right;
    font-size: 28px;
    cursor: pointer;
}

textarea {
    width: 100%;
    padding: 10px;
    resize: vertical;
}

    </style>
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
                <h1>Document Request</h1><br>
                <section class="events">
                    <form action="" method="GET">
                        <select name="status" onchange="this.form.submit()">
                            <option value="All" <?= $selectedStatus === 'All' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $selectedStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Ready To Claim" <?= $selectedStatus === 'Ready To Claim' ? 'selected' : '' ?>>Ready to Claim</option>
                            <option value="Claimed" <?= $selectedStatus === 'Claimed' ? 'selected' : '' ?>>Claimed</option>
                            <option value="Canceled" <?= $selectedStatus === 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                            <option value="Declined" <?= $selectedStatus === 'Declined' ? 'selected' : '' ?>>Declined</option>
                            
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
                                display_request();     
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

    <!-- Reason for Decline Modal -->
<div id="declineModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Reason for Declining</h2>
            <span class="close" id="closeDeclineModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_document_request_controller.php" method="POST">
            <input type="hidden" name="doc_req_id" id="decline_doc_req_id">
            <div class="form-group">
                <label for="decline-reason" >Reason for Declining Request:</label>
                    <select id="decline-reason" name="decline_reason" onchange="toggleOtherpurpose(this.value)">
                        <option value="Incomplete Application">Incomplete Application</option>
                        <option value="Eligibility Issues">Eligibility Issues</option>
                        <option value="Pending Obligations">Pending Obligations</option>
                        <option value="Invalid Request">Invalid Request</option>
                        <option value="Documentation Mismatch">Documentation Mismatch</option>
                        <option value="Regulatory Compliance">Regulatory Compliance</option>
                        <option value="Expired Documents">Expired Documents</option>
                        <option value="Fraud Prevention">Fraud Prevention</option>
                        <option value="Time Constraints">Time Constraints</option>
                        <option value="others">Others</option>

                    </select>
                    <br><br>
                    <div id="other_decline_reason_div" style="display:none;">
                        <textarea name="other_decline_reason" id="other_decline_reason" rows="4"  ></textarea>
                    </div>

                
            </div>
            <div class="form-actions">
                <button type="submit" name="decline" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
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
                    <?php
                        if($requestDetails['request_status'] === "Approved") {
                            ?>
                            <div class="form-group">
                                <label for="expire_date">Expiration Date:</label>
                                <span><input type="date" name="expire_date" id="expire_date" required></span>
                            </div>
                        
                        <?php
                        }
                   
                        else if($requestDetails['request_status'] === "Ready To Claim" || $requestDetails['request_status'] === "Claimed") {
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
                    if ($requestDetails['request_status'] === 'Approved') {
                        echo '<button type="submit" name="claim" class="btn btn-primary">Ready To Claim</button>';
                    } else if ($requestDetails['request_status'] === 'Pending'){ ?>
                        <button type="button" class="btn btn-sec" 
                                onclick="openDeclineModal(<?= $requestDetails['doc_req_id'] ?>)">
                            Decline
                        </button>
                    <?php
                        echo '<button type="submit" name="accept" class="btn btn-primary">Accept</button>';
                    }else if ($requestDetails['request_status'] === 'Ready To Claim') {
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

    var declineModal = document.getElementById("declineModal");
var closeDeclineModal = document.getElementById("closeDeclineModal");

function openDeclineModal(docReqId) {
    document.getElementById("decline_doc_req_id").value = docReqId;
    declineModal.style.display = "block";
}

closeDeclineModal.onclick = function() {
    declineModal.style.display = "none";
};

window.onclick = function(event) {
    if (event.target == declineModal) {
        declineModal.style.display = "none";
    }
};
function toggleOtherpurpose(value) {
    const otherInput = document.getElementById("other_decline_reason");
    const otherDiv = document.getElementById("other_decline_reason_div");
    if (value === "others") {
      otherDiv.style.display = "block";
      otherInput.required = true;
    } else {
      otherDiv.style.display = "none";
      otherInput.required = false;
    }
  }

</script>
</body>
</html>