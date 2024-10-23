var modal = document.getElementById("eventModal");
        var span = document.getElementsByClassName("close")[0];

        function showModal(eventName, eventPosition, eventLocation, eventStart, eventEnd, eventDescription, imgPath) {
            document.getElementById("modalEventName").innerText = eventName;
            document.getElementById("modalEventPosition").innerText = eventPosition;
            document.getElementById("modalEventLocation").innerText = 'Location: ' + eventLocation;
            document.getElementById("modalEventStart").innerText = 'Start: ' + eventStart;
            document.getElementById("modalEventEnd").innerText = 'End: ' + eventEnd;
            document.getElementById("modalEventDescription").innerText = 'Description: ' + eventDescription;
            
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