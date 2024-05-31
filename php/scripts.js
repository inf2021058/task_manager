function toggleTheme() {
    var body = document.body;
    if (body.classList.contains('dark-theme')) {
        body.classList.remove('dark-theme');
        body.classList.add('light-theme');
        document.cookie = "theme=light; path=/";
    } else {
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');
        document.cookie = "theme=dark; path=/";
    }
}

window.onload = function() {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith('theme=')) {
            var theme = cookie.split('=')[1];
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
            } else {
                document.body.classList.add('light-theme');
            }
        }
    }
}
