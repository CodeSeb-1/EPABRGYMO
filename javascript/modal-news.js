var modal = document.getElementById("eventModal");
        var span = document.getElementsByClassName("close")[0];

        function showModal(newsName, newsDescription, newsDate, imgPath) {
            document.getElementById("modalEventName").innerText = newsName;
            document.getElementById("modalNews").innerText = newsName;
            document.getElementById("modalEventDescription").innerText = newsDescription;
            document.getElementById("modalDate").innerText = newsDate;
            
            document.getElementById("modalEventImage").src = imgPath;
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        function closeModal() {
            document.getElementById("eventModal").style.display = "none";
        }