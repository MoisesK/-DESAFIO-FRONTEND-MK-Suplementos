async function populateProducts() {
    try {
        const response = await fetch('src/js/products.json');

        if (!response.ok) {
            console.log('Erro ao recuperar dados dos produtos.')
        }

        await new Promise(resolve => setTimeout(resolve, 2000));

        return await response.json();
    } catch (erro) {
        document.getElementById('items-content').appendChild(notFoundMessage());

        console.error('Erro ao ler o arquivo JSON:', erro);
    }
}

async function searchProduct(term) {
    try {
        const response = await fetch('src/js/products.json');

        if (!response.ok) {
            console.log('Erro ao recuperar dados dos produtos.')
        }

        await new Promise(resolve => setTimeout(resolve, 2000));

        const data = await response.json();

        return data.filter((d) => {
            if (d.name.toLowerCase().includes(term.toLowerCase())) {
                return d;
            }
        })
    } catch (erro) {
        document.getElementById('items-content').appendChild(notFoundMessage());

        console.error('Erro ao ler o arquivo JSON:', erro);
    }
}

function makeItemRender(item) {
    const itemDiv = document.createElement('div');
    itemDiv.classList.add('item');


    itemDiv.innerHTML = `
          <div class="image">
            <img src="${item.image}">
          </div>

          <div class="details">
              <div><span class="title">${item.name}</span></div>
              <div class="amount">
                 <span class="value">R$ ${item.amount}</span>
                 <span class="sufix">${item.sufix}</span> 
              </div>
              <div class="description">${item.description}</div>
          </div>
          <div class="more-informations">
            <button id="more-informations-button-${item.id}" value="${item.id}" class="action-button">
                <i class="fa-solid fa-arrow-right"></i>
                Mais informações
            </button>
          </div>
        `;

    return itemDiv;
}

async function getProductDetails() {
    try {
        const response = await fetch('src/js/product-detail.json');

        if (!response.ok) {
            console.log('Erro ao recuperar dado do produto.')
        }

        await new Promise(resolve => setTimeout(resolve, 2000));

        return await response.json();
    } catch (erro) {
        document.getElementById('items-content').appendChild(notFoundMessage('Serviço não encontrado!'));
        console.error('Erro ao ler o arquivo JSON:', erro);
    }
}