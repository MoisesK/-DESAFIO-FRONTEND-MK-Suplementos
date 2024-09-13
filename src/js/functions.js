function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function makeLoading() {
    const loading = document.createElement('div');
    loading.classList.add('loading');

    const spinner = document.createElement('span');
    spinner.classList.add('spinner');

    loading.appendChild(spinner);

    return loading;
}