(function () {
    var page = location.pathname.split('/').pop() || 'index.html';
    var params = new URLSearchParams(location.search);

    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'css/auth.css';
    document.head.appendChild(link);

    var messages = {
        name: 'Please enter your full name.',
        email: 'Please enter a valid email address.',
        short_password: 'Password must be at least 8 characters.',
        mismatch: 'Passwords do not match.',
        exists: 'That email is already registered.',
        empty: 'Please enter your email and password.',
        invalid: 'Incorrect email or password.',
        server: 'Something went wrong. Please try again later.',
        login_required: 'Please login to view that page.'
    };

    function showMessage(type, text) {
        var form = document.querySelector('.form-section form');
        if (!form) { return; }
        var box = document.createElement('p');
        box.className = 'alert alert-' + type;
        box.textContent = text;
        form.parentNode.insertBefore(box, form);
    }

    if (page === 'login.html' || page === 'register.html') {
        if (params.get('error')) {
            showMessage('error', messages[params.get('error')] || messages.server);
        }
        if (params.get('registered')) {
            showMessage('success', 'Registration successful! You can now login.');
        }
        if (params.get('loggedout')) {
            showMessage('success', 'You have been logged out.');
        }
        if (page === 'register.html') {
            var nameInput = document.getElementById('name');
            var emailInput = document.getElementById('email');
            if (nameInput && params.get('name')) { nameInput.value = params.get('name'); }
            if (emailInput && params.get('email')) { emailInput.value = params.get('email'); }
        }
    }

    if (page === 'profile.html') {
        fetch('api/profile.php', { credentials: 'same-origin' })
            .then(function (res) {
                if (res.status === 401) {
                    location.replace('login.html?error=login_required');
                    return null;
                }
                return res.json();
            })
            .then(function (data) {
                if (!data || !data.loggedIn) { return; }

                var paragraphs = document.querySelectorAll('.profile-info p');
                paragraphs.forEach(function (p) {
                    var label = p.querySelector('strong');
                    if (!label) { return; }
                    var value = label.textContent.indexOf('Name') === 0 ? data.name : data.email;
                    p.innerHTML = '';
                    p.appendChild(label);
                    p.appendChild(document.createTextNode(' ' + value));
                });

                // Swap Login/Register links for Logout while logged in.
                var nav = document.querySelector('.navbar nav');
                if (nav) {
                    nav.querySelectorAll('a').forEach(function (a) {
                        var h = a.getAttribute('href');
                        if (h === 'login.html' || h === 'register.html') { a.remove(); }
                    });
                    var out = document.createElement('a');
                    out.href = 'auth/logout.php';
                    out.textContent = 'Logout';
                    nav.appendChild(out);
                }
            })
            .catch(function () {
                showMessage('error', messages.server);
            });
    }
})();
