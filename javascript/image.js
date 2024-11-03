function previewImage(input) {
    var preview = document.getElementById('userpicture');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; 
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = 'book.jpg'; 
        preview.style.display = 'none';
    }

}


asdasd
asdasdas
asdsdadasda
asdasdasasdasd