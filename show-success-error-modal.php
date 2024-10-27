<script>
<?php if (isset($_SESSION['modal_btn'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        showSuccessModal();
    });
    <?php unset($_SESSION['modal_btn']); ?>
<?php endif; ?>

    function showSuccessModal() {
       document.getElementById("successModal").style.display = "block";
    }

    function closeSuccessModal(redirectUrl = null) {
        document.getElementById("successModal").style.display = "none";
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    }
</script>