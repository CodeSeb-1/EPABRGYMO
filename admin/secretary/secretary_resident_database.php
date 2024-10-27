<?php
include '../calendar.php';
include_once("../adminController/secretaryController/secretary_resident_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PaBrgyMo Calendar</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&" />
    <link rel="stylesheet" href="../../assets/event-calendar.css????">
    <link rel="stylesheet" href="../../assets/pagination.css">
</head>
<body>
    <?php
        include_once("../header.php");
    ?>
    <div class="main-container">
        <?php
            include_once("sidebar.php");
            sidebar("resident");
        ?>
        <main class="content">
            <div class="content home">
            <h1><?php echo isset($result) ? 'Edit Resident' : 'Add Resident'; ?></h1><br>
            <section class="add-event">
        <div class="event-form">
            <form action="../adminController/secretaryController/secretary_resident_controller.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="resident_id" value="<?php echo $result['masterlist_id'] ?? ''; ?>">
            
                        <div class="field">
                            <label>First name:</label>
                            <input type="text" name="firstname" placeholder="First name" required
                                value="<?php echo $result['masterlist_first_name'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Middle name:</label>
                            <input type="text" name="middlename" placeholder="Middle name" required
                                value="<?php echo $result['masterlist_middle_name'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Last name:</label>
                            <input type="text" name="lastname" placeholder="Last name" required
                                value="<?php echo $result['masterlist_last_name'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Contact No.:</label>
                            <input type="text" name="contact" placeholder="Contact No." required
                                value="<?php echo $result['masterlist_contact_num'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Birthdate:</label>
                            <input type="date" name="birthdate" required
                                value="<?php echo $result['masterlist_birthdate'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Email:</label>
                            <input type="email" name="email" placeholder="Email" required
                                value="<?php echo $result['masterlist_email'] ?? ''; ?>">
                        </div>
                        <div class="field">
                            <label>Address:</label>
                            <input type="text" name="address" placeholder="House no., Street" required
                                value="<?php echo $result['masterlist_address'] ?? ''; ?>">
                        </div>
            
                        <div class="field">
                            <label></label>
                            <input type="submit" name="<?php echo isset($result) ? 'edit_resident' : 'add_resident'; ?>"
                                value="<?php echo isset($result) ? 'Edit Resident' : 'Add Resident'; ?>">
                        </div>
                    </form>
                    <div class="image-container">
                        <img src="../../assets/holder-image.png" id="userpicture" alt="image holder">
                    </div>
                </div>
            </section>
            <hr>


            <h1>Master List</h1><br>
            <section class="events" id="request">
                <form method="GET" id="searchForm" action="">
                    <input type="search" id="search" name="search" placeholder="Search by name..." 
                        value="<?php echo $_GET['search'] ?? ''; ?>" 
                        oninput="addRequestAnchor(); this.form.submit()"> <!-- Automatically submit the form on input -->
                    <input type="hidden" name="page" value="<?= $page; ?>">
                </form><br>
                <table id="request_table">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Age</th>
                            <th>Birthday</th>
                            <th>Contact No.</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         display_resident();
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
        </main>
    </div>
    <script src="../../javascript/image.js"></script>
    <script>
        function submitSearchForm() {
            const form = document.getElementById('searchForm');
            const formData = new FormData(form);
            const queryString = new URLSearchParams(formData).toString();
            
            fetch(window.location.pathname + '?' + queryString)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const tableContent = doc.querySelector('table tbody').innerHTML;
                    const paginationContent = doc.querySelector('.pagination').innerHTML;
                    
                    // Update the table and pagination content
                    document.querySelector('table tbody').innerHTML = tableContent;
                    document.querySelector('.pagination').innerHTML = paginationContent;
                    
                    // Keep the search input focused
                    const searchInput = document.getElementById('search');
                    if (searchInput.value) {
                        searchInput.focus();
                        const length = searchInput.value.length;
                        searchInput.setSelectionRange(length, length);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        window.addEventListener('load', function() {
            const searchInput = document.getElementById('search');
            if (searchInput.value) {
                searchInput.focus(); // Focus on the search input
                const length = searchInput.value.length; 
                searchInput.setSelectionRange(length, length); // Move the cursor to the end of the input
            }
        });

        function addRequestAnchor() {
    if (!window.location.href.includes('#request')) {
        window.location.href += '#request';
    }
}  
    </script>

</body>
</html>