<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{mb_strtoupper($product['name'], 'UTF-8')}}</title>
    <link rel="stylesheet" href="{{asset('assets/css/mobile/details/product.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/details/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/mobile/global.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/header.css')}}">
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
    <script src="{{asset('assets/js/components/header.js')}}"></script>
    <script src="{{asset('assets/js/components/footer.js')}}"></script>
</head>
<body>
<section id="platform-content">
    <main-header></main-header>

    <main>
        <section class="general-info">
            <section class="container name">
                <div class="informations"><h3>{{mb_strtoupper($product['name'], 'UTF-8')}}</h3></div>
            </section>

            <section id="carrousel" class="images">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach($product['images'] as $imageSrc)
                            <img class="swiper-slide" src="{{$imageSrc}}" alt="banner" >
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            <section class="container money-info">
                <section class="monetary">
                    <span class="amount-value">R$ {{\App\Helpers\AmountHelper::formatAmountToMoneyReal($product['amount'])}}</span>
                    <span class="amount-sufix">({{ $product['sufix']  }})</span>
                </section>

                <section class="payment-form">
                    <p>NO PIX</p>
                    <span>ou <strong>R$ {{\App\Helpers\AmountHelper::formatAmountToMoneyReal($product['amount'] / 6)}} no cartão de crédito em até 6x sem juros.</strong></span>
                </section>
            </section>

            <section class="container schedule">
                <a href="{{$product['id']}}/checkout">
                    <button id="schedule-this-product" class="action-button">AGENDAR!</button>
                </a>
            </section>
        </section>

        <section class="container description">
            <h3>O que é este serviço?</h3>
            {{$product['description']}}
        </section>
    </main>
    <main-footer payments-image="{{asset('assets/images/metodos-pagamento.webp')}}"></main-footer>

</section>

<section id="toast"></section>

<script src="{{asset('assets/js/populate-products.js')}}"></script>
<script src="{{asset('assets/js/functions.js')}}"></script>
<script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: true,
            autoplay: {
                delay: 8000,
            }
        });

        document.getElementById('overlay').addEventListener('click', (e) => hiddenMenu());
    // })
</script>
</body>
</html>
