const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault();//preventing form for submmiting
};

continueBtn.onclick = () => {
    //ajax time
    let xhr = new XMLHttpRequest();//creating xml object
    xhr.open("POST", "includes/login_function.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                
                if(data === "success") {
                    location.href = "users.php";
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }   
    //send the form data through ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
};