<script>
    var modal = document.getElementById("myModal");
        var span = document.getElementById("closeModal");

        <?php if ($requestDetails): ?>
            modal.style.display = "block";
            window.location.href = "#table"; 
        <?php endif; ?>

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
</script>