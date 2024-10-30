<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link rel="stylesheet" href="assets/style1.css???????">
    <link rel="stylesheet" href="assets/success-modal.css???">
    <link rel="stylesheet" href="assets/modal.css">
</head>
<body>
    <?php
    include_once("header.php");
    nav("reports");
    ?>
    <main>
        <div class="container">
            <section class="form">
                <div class="form-contents">
                    <div class="head">
                    <h1>Report Form</h1>
                <div class="btn">
                        <a href="view_report.php">View reports</a>
                    </div>
                    </div>
                
                    <form action="userController/report_controller.php" method="POST">

                        <div class="form-groups">
                            <label for="report">Type of report <span id="asterisk">*</span> </label>
                            <select name="report_type" id="report_type" required>
                                <option value="">Select report</option>
                                <option value="Personal Dispute">Personal Dispute</option>
                                <option value="Slander/Defamation">Slander/Defamation</option>
                                <option value="Theft">Theft</option>
                                <option value="Physical Assault">Physical Assault</option>
                                <option value="Vandalism">Vandalism</option>
                                <option value="Trespassing">Trespassing</option>
                                <option value="Disturbance of Peace">Disturbance of Peace</option>
                                <option value="Harassment">Harassment</option>
                                <option value="PublicSafety/Hazard">Public Safety/Hazard</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>


                        <div class="form-groups">
                            <label for="documentType">Description of the report <span id="asterisk">*</span> </label>
                            <textarea name="description" required placeholder="Description"
                                class="fixed-height"></textarea>
                        </div>


                        <div class="form-groups">
                            <label for="report">If there are people involved:</label>
                            <input type="text" name="person" placeholder="Name">
                        </div>

                        <div class="form-groups">
                            <div class="form-groups">
                                <label>Purok<span id="asterisk"> *</span> </label><br>
                                <div class="radio-group">
                                    <br>
                                    <label>
                                        <input type="radio" name="purokOption" value="sameAsMe" checked
                                            onchange="toggleAddressInput()"> Same as mine
                                    </label>
                                    <label>
                                        <input type="radio" name="purokOption" value="manual"
                                            onchange="toggleAddressInput()"> Enter manually
                                    </label>
                                </div>
                                <div class="form-groups" id="manualPurokInput" style="display: none;">
                                    <input type="number" id="otherPurok" name="otherPurok" min="1" max="7" placeholder="Enter purok">
                                </div>
                            </div>
                        </div>

                        <input type="submit" name="report" value="Submit Request">
                    </form>
                </div>
            </section>
        </div>
    </main>
        <div id="successModal" class="modal">
                <div class="modal-content success">
                    <div class="modal-header">
                        <h2 style="color:green">Success</h2>
                        <span class="close" onclick="closeSuccessModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>Your report has been successfully submitted!</p><br>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeSuccessModal()" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
    <?php include_once("show-success-error-modal.php") ?>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js?????????"></script>
    <script src="javascript/report.js"></script>
</body>

</html>