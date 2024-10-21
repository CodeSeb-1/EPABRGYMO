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
    <?php
        include_once("header.php");
        nav("reports");
    ?>
    <main>
        <div class="container">
        <section class="form">
            <h1>Report</h1>
            <div class="form-content">
                <form action="userController/report_controller.php" method="POST">

                    <div class="form-group">
                        <label for="report">Type of report:</label>
                        <select name="report" id="report" required>
                            <option value="">Select report</option>
                            <option value="personal_dispute">Personal Dispute</option>
                            <option value="slander_defamation">Slander/Defamation</option>
                            <option value="theft">Theft</option>
                            <option value="physical_assault">Physical Assault</option>
                            <option value="vandalism">Vandalism</option>
                            <option value="trespassing">Trespassing</option>
                            <option value="disturbance">Disturbance of Peace</option>
                            <option value="harassment">Harassment</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="documentType">Description of the report:</label>
                        <textarea name="description" required placeholder="Description" class="fixed-height"></textarea>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="report">Person you want to report:</label>
                        <input type="text" name="person" required placeholder="Name">
                    </div>
                    
                    <input type="submit" name="report" value="Submit Request">
                </form>
            </div>
        </section>
    </div>

    </main>
    <?php include_once("footer.php"); ?>
    <script src="javascript/navbar.js"></script>    
</body>
</html>