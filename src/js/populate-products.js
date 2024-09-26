async function populateProducts() {
    try {
        const response = await fetch('src/js/products.json');

        if (!response.ok) {
            console.log('Erro ao recuperar dados dos produtos.')
        }

        await new Promise(resolve => setTimeout(resolve, 2000));

        return await response.json();
    } catch (erro) {
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
        console.error('Erro ao ler o arquivo JSON:', erro);
    }
}

function makeItemRender(item) {
    const itemDiv = document.createElement('div');
    itemDiv.classList.add('item');

    let stars = '';

    for (let i = 0; i < item.stars; i++)
        stars = stars + '<span class="fa-solid fa-star"></span>';

    itemDiv.innerHTML = `
          <div class="image">
            <img src="${item.image}">
          </div>

          <div class="details">
              <div><span class="title">${item.name}</span></div>
              <div class="stars">
                  ${stars}
              </div>
              <div class="amount">R$ ${item.amount}</div>
          </div>
        `;

    return itemDiv;
}