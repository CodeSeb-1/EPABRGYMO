function toggleEdit() {
    const inputs = document.querySelectorAll('#myModal input, #myModal select, textarea');
    const editBtn = document.getElementById("editBtn");
    const saveBtn = document.getElementById("saveBtn");

    inputs.forEach(input => {
        input.disabled = !input.disabled;
    });

    editBtn.style.display = "none";
    saveBtn.style.display = "inline-block";
}