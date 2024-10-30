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
    <link rel="stylesheet" href="assets/style1.css???????">
    <link rel="stylesheet" href="assets/pagination.css?">
    <link rel="stylesheet" href="assets/modal.css">
    <link rel="stylesheet" href="assets/success-modal.css">
</head>

<body>
    <?php include_once("header.php");
    nav("request") ?>
    <main>
        <div class="container">
            <section class="form">
                <div class="form-contents">
                <div class="head">
                    <h1>Document Request Form</h1>
                    <div class="btn">
                        <a href="view_request.php">View document requests</a>
                    </div>
                </div>
                    <form action="userController/request_controller.php" method="POST">
                        <div class="form-groups">
                            <label>Who is requesting the document?</label>
                            <div class="form-groups">
                                <div class="radio-group">
                                    <br>
                                    <label>
                                            <input type="radio" name="requestor" value="me" checked onchange="toggleRequestor()"required> Me
                                    </label>
                                    <label>
                                        <input type="radio" name="requestor" value="other" onchange="toggleRequestor()"required> Other                            
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-groups" id="meRequestor">
                            <label>Recipient Name:</label>
                            <input type="text" name="originalUser" value="<?php echo $_SESSION['user_fullname']; ?>"
                                readonly>
                        </div>

                        <div id="otherRequestorDetails" style="display: none;">
                            <div class="form-groups">
                                <label for="otherName">Recipient Name:</label>
                                <input type="text" id="otherName" name="otherName" placeholder="Enter full name">
                            </div>
                            <div class="form-groups">
                                <label for="otherBirthday">Requestor Birthday:</label>
                                <input type="date" id="otherBirthday" name="otherBirthday" placeholder="Enter birthday">
                            </div>
                            <div class="form-groups">
                                <label>Relationship:</label>
                                <select name="relationship">
                                    <option value="">Select a relationship</option>
                                    <!-- Nuclear Family Relationships -->
                                    <option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    
                                    <!-- Extended Family Relationships -->
                                    <option value="Grandfather">Grandfather</option>
                                    <option value="Grandmother">Grandmother</option>
                                    <option value="Grandson">Grandson</option>
                                    <option value="Granddaughter">Granddaughter</option>
                                    <option value="Uncle">Uncle</option>
                                    <option value="Aunt">Aunt</option>
                                    <option value="Cousin">Cousin</option>
                                    <option value="Nephew">Nephew</option>
                                    <option value="Niece">Niece</option>
                                    
                                    <!-- In-Law Relationships -->
                                    <option value="Spouse">Spouse</option>
                                    <option value="Father-in-law">Father-in-law</option>
                                    <option value="Mother-in-law">Mother-in-law</option>
                                    <option value="Brother-in-law">Brother-in-law</option>
                                    <option value="Sister-in-law">Sister-in-law</option>
                                    <option value="Son-in-law">Son-in-law</option>
                                    <option value="Daughter-in-law">Daughter-in-law</option>
                                    
                                    <!-- Blended/Step Family Relationships -->
                                    <option value="Step-Father">Step-Father</option>
                                    <option value="Step-Mother">Step-Mother</option>
                                    <option value="Step-Brother">Step-Brother</option>
                                    <option value="Step-Sister">Step-Sister</option>
                                    <option value="Half-Brother">Half-Brother</option>
                                    <option value="Half-Sister">Half-Sister</option>
                                    
                                    <!-- Other Family Relationships -->
                                    <option value="Godfather">Godfather</option>
                                    <option value="Godmother">Godmother</option>
                                    <option value="Godson">Godson</option>
                                    <option value="Goddaughter">Goddaughter</option>
                                    <option value="Adoptive Parent">Adoptive Parent</option>
                                    <option value="Adoptive Sibling">Adoptive Sibling</option>
                                    <option value="Foster Parent">Foster Parent</option>
                                    <option value="Foster Sibling">Foster Sibling</option>
                                </select>
                            </div>
                            <div class="form-groups">
                                <label>Address:</label><br>
                                <div class="radio-group">
                                    <br>
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
                            <div class="form-groups" id="manualAddressInput" style="display: none;">
                                <label for="otherAddress">Requestor Address:</label>
                                <input type="text" id="otherAddress" name="otherAddress" placeholder="Enter address">
                            </div>
                        </div>

                        <div class="form-groups">
                            <label for="documentType">Select a document to request:</label>
                            <select name="documentId" id="documentId" required>
                                <option value="">Select document type</option>
                                <?php display_document(); ?>
                            </select>
                        </div>

                        <div class="form-groups">
                            <label for="purpose">Purpose:</label>
                            <select name="purpose" id="purpose" required>
                                <option value="">Select purpose</option>
                                <!-- Options will be populated dynamically via JavaScript -->
                            </select>
                        </div>
                        <div class="form-groups" id="otherPurpose" style="display: none;">
                            <label for="otherPurpose">Other Purpose:</label><br>
                            <input type="text" id="other_Purpose" name="other_Purpose" placeholder="Enter purpose">
                        </div>


                        <input type="submit" name="request" value="Submit Request">
                    </form>
                </div>
            </section>
            <div id="successModal" class="modal">
                <div class="modal-content success">
                    <div class="modal-header">
                        <h2>Success</h2>
                        <span class="close" onclick="closeSuccessModal('view_request.php')">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>Your request has been successfully sheesh!</p>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeSuccessModal('view_request.php')" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div>
    <?php include_once("show-success-error-modal.php") ?>
    <?php include_once("modal.php"); ?>
    <?php include_once("show-modal.php"); ?>
    </main>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js???????"></script>
    <script src="javascript/request.js"></script>
    <script src="javascript/other.js"></script>
    <script src="javascript/request-location.js"></script>
    <script>
        document.getElementById('documentId').addEventListener('change', function () {
    const docId = this.value;

    if (docId) {
        fetch('fetch_purposes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ documentId: docId }),
        })
            .then((response) => response.json())
            .then((purposes) => updatePurposeOptions(purposes))
            .catch((error) => console.error('Error fetching purposes:', error));
    } else {
        updatePurposeOptions([]); // Clear options if no document selected
    }
});

function updatePurposeOptions(purposes) {
    const purposeSelect = document.getElementById('purpose');
    purposeSelect.innerHTML = '<option value="">Select purpose</option>';

    purposes.forEach((purpose) => {
        const option = document.createElement('option');
        option.value = purpose.trim();
        option.textContent = purpose.trim();
        purposeSelect.appendChild(option);
    });

    // Display the "Other Purpose" input if needed
    purposeSelect.addEventListener('change', function () {
        const otherPurposeDiv = document.getElementById('otherPurpose');
        otherPurposeDiv.style.display = this.value === 'others' ? 'block' : 'none';
    });
}

    </script>
</body>

</html>