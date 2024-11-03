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
                            <option value="In Progress" <?= $selectedStatus === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="On Hold" <?= $selectedStatus === 'On Hold' ? 'selected' : '' ?>>On Hold</option>
                            <option value="Resolved" <?= $selectedStatus === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            <option value="Closed" <?= $selectedStatus === 'Closed' ? 'selected' : '' ?>>Closed</option>
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
    
<!-- On Hold Modal -->
<div id="onHoldModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Put Report On Hold</h2>
            <span class="close" id="closeOnHoldModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_reports_controller.php" method="POST">
            <input type="hidden" name="report_id" id="hold_report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?= $requestDetails['user_id'] ?? '' ?>">
            <div class="form-group">
                <label for="hold_reason">Reason for Hold:</label>
                <textarea name="hold_reason" id="hold_reason" rows="4" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" name="on_hold" class="btn btn-primary">Confirm Hold</button>
            </div>
        </form>
    </div>
</div>

<!-- Resolved Modal -->
<div id="resolvedModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Mark Report as Resolved</h2>
            <span class="close" id="closeResolvedModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_reports_controller.php" method="POST">
            <input type="hidden" name="report_id" id="resolved_report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?= $requestDetails['user_id'] ?? '' ?>">
            <div class="form-group">
                <label for="resolution_notes">Resolution Notes:</label>
                <textarea name="resolution_notes" id="resolution_notes" rows="4" ></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" name="resolved" class="btn btn-primary">Confirm Resolution</button>
            </div>
        </form>
    </div>
</div>

<!-- Closed Modal -->
<div id="closedModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Close Report</h2>
            <span class="close" id="closeClosedModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_reports_controller.php" method="POST">
            <input type="hidden" name="report_id" id="closed_report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?= $requestDetails['user_id'] ?? '' ?>">
            <div class="form-group">
                <label for="closure_reason">Closure Reason:</label>
                <textarea name="closure_reason" id="closure_reason" rows="4" ></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" name="closed" class="btn btn-primary">Confirm Closure</button>
            </div>
        </form>
    </div>
</div>
<!-- Decline Reason Modal for Reports -->
<div id="reportDeclineModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Reason for Declining Report</h2>
            <span class="close" id="closeReportDeclineModal">&times;</span>
        </div>
        <form action="../adminController/secretaryController/secretary_reports_controller.php" method="POST">
            <input type="hidden" name="report_id" id="decline_report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?= $requestDetails['user_id'] ?? '' ?>">
            <div class="form-group">
                <label for="decline_reason">Reason for Declining:</label>
                <select id="decline_reason" name="decline_reason" onchange="toggleOtherPurpose(this.value)">
                    <option value="Incomplete Report">Incomplete Report</option>
                    <option value="Eligibility Issues">Eligibility Issues</option>
                    <option value="Invalid Report">Invalid Report</option>
                    <option value="Fraud Prevention">Fraud Prevention</option>
                    <option value="others">Others</option>
                </select>
                <br><br>
                <div id="other_decline_reason_div" style="display:none;">
                    <textarea name="other_decline_reason" id="other_decline_reason" rows="4"></textarea>
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
            <h2 class="modal-title">Report Details</h2>
            <span class="close" id="closeModal">&times;</span>
        </div>

        <form action="../adminController/secretaryController/secretary_reports_controller.php" method="POST">
            <input type="hidden" name="report_id" value="<?= $requestDetails['report_id'] ?? '' ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?= $requestDetails['user_id'] ?? '' ?>">
    
                <div id="modal-body" class="form-content">
                    <div class="form-column">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <span><?= $requestDetails['full_name'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label>Report Type:</label>
                            <span><?= $requestDetails['report_type'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <span><?= $requestDetails['report_content'] ?? '' ?></span>
                        </div>
    
                        <?php if (!empty($requestDetails['report_name'])): ?>
                            <div class="form-group">
                                <label>Person Involved:</label>
                                <span><?= $requestDetails['report_name'] ?? '' ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
    
                    <div class="form-column">
                        <div class="form-group">
                            <label class="<?= $statusClass ?>">Purok:</label>
                            <span><?= $requestDetails['report_purok'] ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label>Reported Date:</label>
                            <span><?= $formattedDate ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <span><?= $requestDetails['report_status'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
    
                <div class="form-actions" id="form-actions">
                    <?php if ($requestDetails): ?>
                        <?php switch ($requestDetails['report_status']):
                            case 'Pending': ?>
                                <button type="button" onclick="openReportDeclineModal('<?= $requestDetails['report_id'] ?>')"
                                    class="btn btn-sec">Decline</button>
                                <button type="submit" name="in_progress" class="btn btn-primary">Start Progress</button>
                                <?php break; ?>
    
                            <?php case 'In Progress': ?>
                                <button type="button" onclick="openOnHoldModal('<?= $requestDetails['report_id'] ?>')"
                                    class="btn btn-sec">Put on Hold</button>
                                <button type="button" onclick="openResolvedModal('<?= $requestDetails['report_id'] ?>')"
                                    class="btn btn-primary">Mark as Resolved</button>
                                <?php break; ?>
    
                            <?php case 'On Hold': ?>
                                <button type="submit" name="in_progress" class="btn btn-primary">Continue</button>
                                <button type="button" onclick="openClosedModal('<?= $requestDetails['report_id'] ?>')"
                                    class="btn btn-sec">Close Report</button>
                                <?php break; ?>
    
                            <?php case 'Resolved': ?>
                                <button type="button" onclick="openClosedModal('<?= $requestDetails['report_id'] ?>')"
                                    class="btn btn-primary">Close Report</button>
                                <?php break; ?>
    
                    
                        <?php endswitch; ?>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

<script>
    // Store references to all modals
    const modals = document.querySelectorAll('.modal');

    // Main modal and its close button
    const mainModal = document.getElementById('myModal');
    const closeMainModal = document.getElementById('closeModal');

    // Function to close all modals
    function closeAllModals() {
        modals.forEach(modal => modal.style.display = 'none');
    }

    // Open a specific modal and ensure others are closed
    function openModal(modalId, reportIdField = null, reportId = null) {
        closeAllModals(); // Ensure only one modal stays open
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        if (reportIdField && reportId) {
            document.getElementById(reportIdField).value = reportId;
        }
    }

    // Close a specific modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    // Close all modals if clicking outside of one
    window.onclick = function (event) {
        modals.forEach(modal => {
            if (event.target == modal) {
                closeAllModals();
            }
        });
    };

    // Toggle 'Other Decline Reason' input visibility
    function toggleOtherPurpose(value) {
        const otherDiv = document.getElementById('other_decline_reason_div');
        const otherInput = document.getElementById('other_decline_reason');
        if (value === 'others') {
            otherDiv.style.display = 'block';
            otherInput.required = true;
        } else {
            otherDiv.style.display = 'none';
            otherInput.required = false;
        }
    }

    // Event listeners for closing modals by their 'X' buttons
    closeMainModal.onclick = () => closeModal('myModal');
    document.getElementById('closeOnHoldModal').onclick = () => closeModal('onHoldModal');
    document.getElementById('closeResolvedModal').onclick = () => closeModal('resolvedModal');
    document.getElementById('closeClosedModal').onclick = () => closeModal('closedModal');
    document.getElementById('closeReportDeclineModal').onclick = () => closeModal('reportDeclineModal');

    // Functions to open each specific modal
    function openOnHoldModal(reportId) {
        openModal('onHoldModal', 'hold_report_id', reportId);
    }

    function openResolvedModal(reportId) {
        openModal('resolvedModal', 'resolved_report_id', reportId);
    }

    function openClosedModal(reportId) {
        openModal('closedModal', 'closed_report_id', reportId);
    }

    function openReportDeclineModal(reportId) {
        openModal('reportDeclineModal', 'decline_report_id', reportId);
    }

    // Automatically open the main modal if request details exist
    <?php if ($requestDetails): ?>
        openModal('myModal');
    <?php endif; ?>
</script>

</body>
</html>