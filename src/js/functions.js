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

function toast(message = 'Erro', type = 'error') {
    const toast = document.getElementById('toast')
    toast.textContent = message;

    toast.classList.add(type);
    toast.style.opacity = '1';

    setTimeout(() => {
        toast.classList.remove(type);
        toast.style.opacity = '0';
    }, 3000);
}