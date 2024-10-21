<?php
include_once("userController/request_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPABRGYMO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_right" />
    <link rel="stylesheet" href="assets/style1.css">
</head>
<body>
    <?php include_once("header.php"); nav("request") ?>
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
                                    <input type="radio" name="requestor" value="me" checked onchange="toggleRequestor()" required> Me
                                </label>
                                <label>
                                    <input type="radio" name="requestor" value="other" onchange="toggleRequestor()" required> Other
                                </label>
                            </div>
                        </div>
    
                        <div class="form-group" id="meRequestor">
                            <label>Requestor Name:</label>
                            <input type="text" name="originalUser" value="<?php echo $_SESSION['user_fullname']; ?>" readonly>
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
                                        <input type="radio" name="addressOption" value="sameAsMe" checked onchange="toggleAddressInput()"> Same as my address
                                    </label>
                                    <label>
                                        <input type="radio" name="addressOption" value="manual" onchange="toggleAddressInput()"> Enter manually
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
                            <select name="purpose" id="purpose" required>
                                <option value="">Select purpose</option>
                                <option value="scholarship">Scholarship</option>
                                <option value="financialAssistance">Financial Assistance</option>
                                <option value="workRelated">Work Related</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
    
                        <input type="submit" name="request" value="Submit Request">
                    </form>
                </div>
            </section>
        </div>
    </main>
    <?php include_once("footer.php");?>
    <script src="javascript/navbar.js"></script>
    <script src="javascript/request.js"></script>
</body>
</html>