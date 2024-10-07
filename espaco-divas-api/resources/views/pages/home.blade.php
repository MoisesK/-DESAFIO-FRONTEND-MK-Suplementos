<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{env('APP_NAME')}}</title>

    <link rel="stylesheet" href="{{asset('assets/css/mobile/global.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/header.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/home/products.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/home/items.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/footer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/nav-bar.css')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eb9613833e.js" crossorigin="anonymous"></script>

    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('assets/js/components/footer.js')}}"></script>
    <script src="{{asset('assets/js/components/header-with-filter.js')}}"></script>
</head>
<body>
    <section id="platform-content">

        <main-header-filter></main-header-filter>

      <main>
          <section id="carrousel" class="banner-section">
              <div class="swiper">
                  <div class="swiper-wrapper">
                      <img class="swiper-slide" src="src/images/banner.jpg" alt="banner" >
                      <img class="swiper-slide" src="src/images/banner2.jpg" alt="banner" >
                  </div>
              </div>
          </section>

          <section class="container products">
              <div class="informations">
                  <h3>PROMOÇÕES</h3>
              </div>
              <div id="items-count" class="items-count"></div>
          </section>

          <section class="container items-content">
              <div id="items-content" class="content">
                  @if(!empty($items))
                      @foreach($items as $item)
                          <div class="item">
                              <div class="image">
                                  <img src="{{$item['images'][0]}}">
                              </div>

                              <div class="details">
                                  <div><span class="title">{{strtoupper($item['name'])}}</span></div>
                                  <div class="amount">
                                      <span class="value">R$ {{\App\Helpers\AmountHelper::formatAmountToMoneyReal($item['amount'])}}</span>
                                      <span class="sufix">({{$item['sufix']}})</span>
                                  </div>
                                  <div class="description">{{$item['description']}}</div>
                              </div>
                              <div class="more-informations">
                                  <a href="/{{$item['id']}}">
                                      <button id="more-informations-button-{{$item['id']}}" value="{{$item['id']}}" class="action-button">
                                          <i class="fa-solid fa-arrow-right"></i>
                                          Mais informações
                                      </button>
                                  </a>
                              </div>
                          </div>
                      @endforeach
                  @else
                      <div class="center-item">
                          <span class="medium-text">Nenhum serviço encontrado!</span>
                      </div>
                  @endif
              </div>
          </section>
      </main>
        <main-footer payments-image="{{asset('assets/images/metodos-pagamento.webp')}}"></main-footer>

    </section>

    <section id="toast"></section>

    <script src="{{asset('assets/js/populate-products.js')}}"></script>
    <script src="{{asset('assets/js/functions.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const itensCount = document.getElementById('items-count')
            itensCount.innerHTML = `<h3>{{count($items)}} Produtos</h3>`;

            document.getElementById('newsletter-subscription-button').addEventListener('click', (e) => {
                e.preventDefault();
                const email = document.getElementById('newsletter-mail');

                if (email.value.length == 0) {
                    email.style.border = '2px red solid';

                    toast('Campo de email não pode está vazio!');
                    return;
                }

                if (!validateEmail(email.value)) {
                    email.style.border = '2px red solid';
                    email.style.borderRight = 'none';

                    toast('Email informado está no formato inválido.');

                    return;
                }

                email.style.border = 'darkgray solid 1pt';

                toast(`O email ${email.value} foi inscrito em nosso catálogo de promoções!`, 'success');

                email.value = '';
            })

            document.getElementById('filter-search').addEventListener('click', (e) => {
                e.preventDefault();
                itemsContentDiv.innerHTML = '';

                itemsContentDiv.appendChild(loading);

                const input = document.getElementById('filter-input');
                searchProduct(input.value).then((r) => {
                    if (r.length === 0) {
                        itemsContentDiv.removeChild(loading)
                        document.getElementById('items-content').appendChild(notFoundMessage());
                        return;
                    }

                    itemsContentDiv.removeChild(loading)
                    const contentSection = document.getElementById('items-content');

                    r.forEach((d) => contentSection.appendChild(makeItemRender(d)))

                    const itensCount = document.getElementById('items-count')
                    itensCount.innerHTML = `<h3>${r.length} Encontrados</h3>`;
                });
            })

            const swiper = new Swiper('.swiper', {
                direction: 'horizontal',
                loop: true,
                autoplay: {
                    delay: 8000,
                },
                height: 800
            });

            document.getElementById('overlay').addEventListener('click', (e) => hiddenMenu());
        })
    </script>
</body>
</html>
