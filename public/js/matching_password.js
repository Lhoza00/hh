const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const err = document.getElementById('pwError');

confirmPassword.addEventListener('blur', function () {
    if (confirmPassword.value === '') return;

    if (password.value !== confirmPassword.value) {
        err.classList.add('show');
        confirmPassword.value = '';
        confirmPassword.placeholder = 'Passwords do not match';
        confirmPassword.focus();
    } else {
        err.classList.remove('show');
    }
});

document.querySelector('form').addEventListener('submit', function (e) {
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        err.classList.add('show');
        confirmPassword.focus();
    } else {
        err.classList.remove('show');
    }
});