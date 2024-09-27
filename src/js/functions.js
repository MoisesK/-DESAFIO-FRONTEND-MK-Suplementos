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

function notFoundMessage(message = 'Nenhum serviço encontrado!') {
    const div = document.createElement('div');
    div.classList.add('center-item');

    const text = document.createElement('span');
    text.classList.add('medium-text');

    text.innerText = message;

    div.appendChild(text);

    return div;
}

function toast(message = 'Erro', type = 'error') {
    const toast = document.getElementById('toast')
    toast.textContent = message;

    toast.classList.add(type);
    toast.style.opacity = '1';

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.classList.remove(type);
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

function cancelTerm() {
    const termSection = document.getElementById('cancel-term');
    termSection.classList.toggle('active');
}