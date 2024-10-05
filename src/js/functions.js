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

function showMenu() {
    const minhaDiv = document.getElementById('navbar');
    const overlay = document.getElementById('overlay');

    minhaDiv.style.removeProperty('display');

    minhaDiv.style.animation = 'slideIn 0.5s forwards';
    minhaDiv.style.display = 'flex';
    overlay.style.display = 'block';

    document.querySelector('body').style.overflowY = 'hidden';
}

function hiddenMenu() {
    const minhaDiv = document.getElementById('navbar');
    minhaDiv.style.animation = 'slideOut 0.5s forwards';
    overlay.style.display = 'none';
    document.querySelector('body').style.overflowY = 'auto';
}

function cancelTerm() {
    const termSection = document.getElementById('cancel-term');
    termSection.classList.toggle('active');
}

function applyNumberMask(value, mask) {
    const onlyNumbers = value.replace(/\D/g, '');

    let result = '';
    let iNumber = 0;

    for (let i = 0; i < mask.length; i++) {
        if (mask[i] === '#') {
            if (iNumber < onlyNumbers.length) {
                result += onlyNumbers[iNumber];
                iNumber++;
            } else {
                break;
            }
        } else {
            result += mask[i];
        }
    }

    return result;
}