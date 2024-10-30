<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_add_document_controller.php");
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
    <link rel="stylesheet" href="../../assets/success-modal.css????">
    <style>
        :root {
            --main-red:#D04848;
            --main-hover-red: #b73c3c;
            --second-main-red: #C90508;
            --white: #fff;
            --background-middle-white: #f0f2f5;
            --sidebar-text-color: #7a7a7a;
            --input-color-gray: #636e73;

            --light-black: #1A1A19;


            --regular-size: 13px;
        }
        #declineModal {
            z-index: 1001; /* Make it higher than myModal */
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

        tr > td > a > span.edit {
            color: #51ce57;
        }

        tr > td > a > span.delete {
            color: var(--main-hover-red);
        }

    </style>
</head>
<body>
    <?php include_once("../header.php"); ?>
    <div class="main-container">
        <?php
            include_once("sidebar.php");
            sidebar("document_add");
        ?>
        <main class="content">
            <!-- ADD DOCUMENT -->
            <div class="content home" id="documents">
                <h1>
                    <?php 
                    if(isset($_GET['id'])) {
                        echo"Edit Document";
                    } else {
                        echo"Add Document";
                    }
                    ?>
                </h1>
                <br>
                <section class="add-event">
                    <div class="event-form" id="calendarss">
                        <form action="../adminController/secretaryController/secretary_add_document_controller.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="doc_type_id" value="<?= htmlspecialchars($document['doc_type_id'] ?? '') ?>">

                            <div class="field">
                                <label>Document:</label>
                                <input type="text" name="document_type" placeholder="Document Type" required value="<?= htmlspecialchars($document['doc_name'] ?? '') ?>">
                            </div>
                            <div class="field">
                                <label>Purpose:</label>
                                <input type="text" name="document_purpose" placeholder="Purpose" required value="<?= htmlspecialchars($document['doc_purpose'] ?? '') ?>">
                            </div>
                            <div class="field">
                                <label>Has Payment:</label>
                                <select name="has_payment" required>
                                    <option value="">Choose</option>
                                    <option value="Yes" <?= isset($document['has_payment']) && $document['has_payment'] === 'Yes' ? 'selected' : '' ?>>Yes</option>
                                    <option value="No" <?= isset($document['has_payment']) && $document['has_payment'] === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                            </div>
                            <div class="field"> 
                                <label></label>
                                <?php
                                    if(isset($_GET['id'])) {
                                        echo '<input type="submit" name="update_document" value="Update Document">';
                                    } else {
                                        echo'<input type="submit" name="add_document" value="Add Document">';
                                    }
                                ?>
                                
                            </div>
                        </form>
                    </div>
                    <hr>
                    <table>
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th>Purpose</th>
                                <th>Has Payment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php display_documents(); ?>
                        </tbody>
                    </table>

                    <div class="pagination">
                        <span>Showing <?php echo $page_1; ?> of <?php echo $pages_1; ?></span>
                        <a href="?page_1=1&status=<?= urlencode($selectedStatus) ?>#documents">First</a>
                        <a href="?page_1=<?= max(1, $page_1 - 1) ?>&status=<?= urlencode($selectedStatus) ?>#documents">Previous</a>
                        
                        <div class="page-numbers">
                            <?php for ($i = 1; $i <= $pages_1; $i++): ?>
                                <a href="?page_1=<?= $i ?>&status=<?= urlencode($selectedStatus) ?>#documents" <?= ($i == $page_1) ? 'class="active"' : '' ?>><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                        
                        <a href="?page_1=<?= min($pages_1, $page_1 + 1) ?>&status=<?= urlencode($selectedStatus) ?>#documents">Next</a>
                        <a href="?page_1=<?= $pages_1 ?>&status=<?= urlencode($selectedStatus) ?>#documents">Last</a>
                    </div>
            </section>
        </main>
    </div>
    <div id="successModal" class="modal">
        <div class="modal-content success">
            <div class="modal-header">
                <h2 style="color:green">Success</h2>
                <span class="close" onclick="closeSuccessModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p><?php echo$_SESSION['message_modal'] ?? ''; ?></p><br>
            </div>
            <div class="modal-footer">
                <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
    <!--MODAL ADD DOCUMENT-->

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Document Details</h2>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <form action="../adminController/secretaryController/secretary_add_document_controller.php" method="POST">
                <?php $_SESSION['doc_type_id'] = $requestDetails['doc_type_id']; ?>
                <input type="hidden" name="doc_type_id" id="doc_type_id" value="<?= $requestDetails['doc_type_id'] ?? '' ?>">
                <!-- <img id="modalEventImage" src="<?php echo "/EPABRGYMO/dataImages/Events.{$requestDetails['event_id']}.jpg"; ?>" alt=""><br><br><br> -->
                <div id="modal-body" class="form-content">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="doc_name">Document:</label>
                            <span>
                                <input type="text" id="doc_name" name="document_type" value="<?= $requestDetails['doc_name'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="doc_purpose">Purpose:</label>
                            <span>
                                <input type="text" id="doc_purpose" name="document_purpose" value="<?= $requestDetails['doc_purpose'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label for="has_payment">Has Payment:</label>
                            <span>
                                <input type="text" id="has_payment" name="has_payment" value="<?= $requestDetails['has_payment'] ?? '' ?>" disabled required>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Date:</label>
                            <span>
                                <input type="text" id="created_at" name="created_at" value="<?= $formattedIssuedDate ?? '' ?>" disabled required>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-actions" id="form-actions">
                    <button type="submit" name="remove_document" class="btn btn-sec">Remove</button>
                    <button type="button" class="btn btn-primary" onclick="toggleEdit()" id="editBtn">Edit</button> 
                    <button type="submit" name="update_document" class="btn btn-primary" style="display: none;" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../javascript/toggle-edit.js"></script>
<?php include_once("../../show-success-error-modal.php") ?>
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

    function openDeclineModal(docReqId,user_id) { 
        document.getElementById("decline_doc_req_id").value = docReqId;
        document.getElementById("user_id").value = user_id;
        declineModal.style.display = "block";
        modal.style.display = "none";
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