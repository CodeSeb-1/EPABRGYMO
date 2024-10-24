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
        </form>
    </div>