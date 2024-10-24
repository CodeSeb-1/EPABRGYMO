function addRequestAnchor() {
    if (!window.location.href.includes('#request')) {
        window.location.href += '#request';
    }
}  