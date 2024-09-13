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