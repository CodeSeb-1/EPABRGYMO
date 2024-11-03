function openImageModal(imageSrc) {
    const modal = document.getElementById('fullImageModal');
    const fullImageView = document.getElementById('fullImageView');

    fullImageView.src = imageSrc;

    modal.style.display = 'block';
}

function closeImageModal() {
    const modal = document.getElementById('fullImageModal');
    
    modal.style.display = 'none';
}

//pag open ng image sa modal