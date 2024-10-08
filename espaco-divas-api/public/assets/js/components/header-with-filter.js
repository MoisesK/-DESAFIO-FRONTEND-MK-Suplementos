class Header extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
            <section id="navbar">
            <div class="nav-header">
                <img class="avatar" src="src/images/avatar.jpg">
                <div class="title"><h3>Olá, visitante</h3></div>
            </div>
            <div class="nav-content">
                <a href="/"><i class="fa-solid fa-home"></i>Home</a>
                <a href="#"><i class="fa-solid fa-user"></i>Minha Conta</a>
                <a href="#"><i class="fa fa-shopping-cart"></i>Meus Pedidos</a>
            </div>
        </section>
        <section id="overlay"></section>
        <header>
          <section class="header container">
              <div class="logo">
                  <button id="mobile-menu" class="material-symbols-outlined" onclick="showMenu()">menu</button>
                  <h1>Espaço Divas</h1>
                  <button id="mobile-cart-icon" class="material-symbols-outlined" onclick="redirect('checkout.html')">shopping_cart</button>
              </div>
              <div class="filter">
                  <div class="search-form">
                      <form>
                          <input id="filter-input" placeholder="Pesquisar produto">
                          <button id="filter-search" class="material-symbols-outlined">search</button>
                      </form>
                  </div>
              </div>
          </section>
        </header>

        `
    }
}

customElements.define('main-header-filter', Header);
