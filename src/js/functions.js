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

let menuActive = false;

function showMenu() {
    if (menuActive) {
        return;
    }

    const minhaDiv = document.getElementById('navbar');
    const overlay = document.getElementById('overlay');

    minhaDiv.style.removeProperty('display');

    minhaDiv.style.animation = 'slideIn 0.5s forwards';
    minhaDiv.style.display = 'flex';
    overlay.style.display = 'block';

    document.querySelector('body').style.overflowY = 'hidden';

    setInterval(() => {
        menuActive = true;
    }, 2000)
}

function hiddenMenu() {
    const minhaDiv = document.getElementById('navbar');
    if (!minhaDiv.contains(event.target) && menuActive) {
        minhaDiv.style.animation = 'slideOut 0.5s forwards';
        overlay.style.display = 'none';
        document.querySelector('body').style.overflowY = 'auto';

        setInterval(() => {
            minhaDiv.style.display = 'none';
            menuActive = false;
        }, 2000)
    }
}