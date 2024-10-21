window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    const text = document.querySelector('header nav .user-info a');

    
    if (window.scrollY > 0) {
        header.style.backgroundColor = '#fff'; 
        header.style.boxShadow='0 0 5px rgba(0,0,0,0.1)'
        text.style.color = '#333';
   } else {
        header.style.backgroundColor = 'transparent';
        header.style.boxShadow='none'
        text.style.color = '#fff';
    }
});