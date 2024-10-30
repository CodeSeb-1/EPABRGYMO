<style>
    select#reason {
        width: 100%;
        background: transparent;
        outline: none;
        border: none;
        color: #2c3e50;
    }
</style>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Document Request Details</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>
        <form action="userController/request_controller.php" method="POST">
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
                           } else if($requestDetails['request_status'] === "Pending") { ?>
                            <div class="form-group">
                                <label for="reason">Reason for cancelling:</label>
                                <span><select name="reason" id="reason" required>
                                    <option value="">Select a reason</option>
                                    <option value="Duplicate Request">Duplicate Request</option>
                                    <option value="Incorrect Information">Incorrect Information</option>
                                    <option value="No Longer Needed">No Longer Needed</option>
                                    <option value="Error in Document">Error in Document</option>
                                    <option value="Change in Personal Details">Change in Personal Details</option>
                                    <option value="Submitted by Mistake">Submitted by Mistake</option>
                                    <option value="Wrong Document Type">Wrong Document Type</option>
                                    <option value="Delay in Processing">Delay in Processing</option>
                                    <option value="Changed Circumstances">Changed Circumstances</option>
                                </select>
                                </span>

                                <!-- <span><input type="text" id="reason" name="reason" placeholder="Reason" required></span> -->
                            </div>
                        <?php        
                            } else if($requestDetails['request_status'] === "Ready To Claim" || $requestDetails['request_status'] === "Claimed") {
                            ?>
                            <div class="form-group">
                                <label for="issued_date">Duration:</label>
                                <span id="issued_date"><?= $duration?></span>
                            </div>
                        <?php
                        } else if ($requestDetails['request_status'] === "Canceled"|| $requestDetails['request_status'] === "Declined") {?>
                            <div class="form-group">
                                <label for="reason">
                                    <?= $requestDetails['request_status'] === "Canceled" ? "Reason for Cancellation" : "Reason for Request Denial"; ?>
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
                    if ($requestDetails['request_status'] === 'Pending') {
                        echo '<button type="submit" name="cancel" class="btn btn-primary">Confirm</button> ';
                    }
                }
                ?>
            </div>
        </form>
    </div>