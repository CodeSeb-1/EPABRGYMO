function showSuccessModal() {
    document.getElementById("successModal").style.display = "block";
}

function closeSuccessModal() {
    document.getElementById("successModal").style.display = "none";
}

// Automatically show modal on successful cancellation
if (typeof cancellationSuccess !== 'undefined' && cancellationSuccess) {
    showSuccessModal();
}
