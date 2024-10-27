const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault();
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();//creating xml object
    xhr.open("POST", "includes/insertchat_function.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                inputField.value = "";   
            }
        }
    }   
    //send the form data through ajax to php
    let formData = new FormData(form);
    xhr.send(formData);
};

setInterval(() => {
    //ajax time
    let xhr = new XMLHttpRequest();//creating xml object
    xhr.open("POST", "includes/getchat_function.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
            }
        }
    }  
    let formData = new FormData(form);
    xhr.send(formData);
}, 500); //mag run lang after 500ms