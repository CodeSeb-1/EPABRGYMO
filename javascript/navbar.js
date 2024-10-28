window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    const links = document.querySelectorAll('header nav .user-info a'); // Select all user-info links
    const notificationIcon = document.querySelector('header nav .notifications span.material-symbols-outlined'); // Notification icon
    const notificationCount = document.querySelector('header nav .notif-count'); // Notification count

    if (window.scrollY > 0) {
        header.style.backgroundColor = '#fff'; 
        header.style.boxShadow = '0 0 5px rgba(0,0,0,0.1)';
        links.forEach(link => link.style.color = '#333'); // Change color of all user-info links
        if (notificationIcon) notificationIcon.style.color = '#333'; // Change notification icon color
        if (notificationCount) notificationCount.style.color = '#333'; // Change notification count color
    } else {
        header.style.backgroundColor = 'transparent';
        header.style.boxShadow = 'none';
        links.forEach(link => link.style.color = '#fff'); // Change back to white when at the top
        if (notificationIcon) notificationIcon.style.color = '#fff'; // Change notification icon color back to white
        if (notificationCount) notificationCount.style.color = '#fff'; // Change notification count color back to white
    }
});
