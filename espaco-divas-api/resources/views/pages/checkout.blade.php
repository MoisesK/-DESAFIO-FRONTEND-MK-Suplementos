<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <link rel="stylesheet" href="{{asset('assets/css/mobile/global.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/header.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/footer.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/nav-bar.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/mobile/checkout/product-card.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/checkout/service-tax.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mobile/checkout/schedule-form.css')}}">
    @vite([])


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://kit.fontawesome.com/eb9613833e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{asset('assets/js/components/header.js')}}"></script>
    <script src="{{asset('assets/js/components/footer.js')}}"></script>
</head>
<body>
<section id="platform-content">
    <main-header></main-header>

    <main>
        <section class="general-info">
            <section id="cart-card" class="container cart-card">
                <div class="title-cart">
                    <h3>
                        <i class="fa fa-shopping-cart"></i>
                              Carrinho de serviços</h3>
                <hr>
                </div>
                <div class="cart-items">
                    <div class="product-card">
                        <div class="image">
                            <img src="{{$product['images'][0]}}" alt="banner" >
                        </div>
                        <div class="card-details">
                            <div class="container informations"><h3>{{$product['name']}}</h3></div>
                            <div class="container money-info">
                                <div class="monetary">
                                    <span class="amount-value">R$ {{\App\Helpers\AmountHelper::formatAmountToMoneyReal($product['amount'])}}</span>
                                    <span class="amount-sufix">{{$product['sufix']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <section id="loading" class="container hidden"></section>

        <form id="regForm" class="container" action="">
            <section class="container" style="text-align: center; border-bottom: 1px var(--gray-color) solid;">
                <span class="medium-text" style=>Dados para o agendamento:</span>
            </section>

            <div class="tab">
                <div class="heading-text">
                    <span class="small-text">Escolha a data que deseja realizar seu agendamento!</span>
                </div>
                <div class="date-picker">
                    <input id="schedule-date" type="datetime-local" name="schedule-date" />
                </div>

                <div class="heading-text">
                    <span class="small-text">Preencha com seus dados, para validação do agendamento!</span>
                </div>
                <div class="customer-data">
                    <div class="field-input">
                        <label for="schedule-customer-name">Nome:</label>
                        <input id="schedule-customer-name" type="text" name="schedule-name" placeholder="fulano de tal"/>
                    </div>
                    <div class="field-input">
                        <label for="schedule-customer-email">Email:</label>
                        <input id="schedule-customer-email" type="text" placeholder="email@email.com" name="schedule-email" />
                    </div>
                    <div class="field-input">
                    <label for="schedule-customer-phone">Telefone:</label>
                    <input id="schedule-customer-phone" type="text" placeholder="(85) 99999-9999" maxlength="15" name="schedule-phone" />
                </div>
                </div>
            </div>

            <div class="tab">
                <div class="qr-step">
                    <div class="text-section">
                        <h3 class="medium-text">Realize o pagamento no valor</h3>
                        <h3 class="medium-text amount-value">R$ {{\App\Helpers\AmountHelper::formatAmountToMoneyReal(\App\Helpers\AmountHelper::calculateTax($product['amount'], 0.50))}}</h3>
                    </div>
                    <div class="qr-content">
                        {!! $qrCodeImage !!}
                        <div class="copy-section">
                            <span id="copy-paste-pix-action"><i class="fa fa-clipboard"></i></span>
                            <input id="copy-paste-pix-value" class="copy-paste-pix" value="{{$copyPastePixCode}}" disabled>
                        </div>
                    </div>
                    <div>
                        <ol>
                            <li>
                                Abra o app do seu banco ou instituição
                                financeira e entre no ambiente Pix.
                            </li>
                            <li>
                                Escolha a opção pagar com qr code e escaneie ou utilize a opção copia e cola
                                o código.
                            </li>
                            <li>
                                Confirme as informações, faça o pagamento e salve o comprovante.
                            </li>
                            <li>
                                Anexe o comprovante e prossiga com as etapas do agendamento.
                            </li>
                        </ol>
                    </div>
                    <div>
                        <div class="proof-file-input">
                            <input id="payment-proof-file-input" type="file">
                        </div>
                    </div>
                </div>
            </div>

            <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Próximo</button>
                </div>
            </div>

            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </form>

        <section id="proof-file-received" class="hidden">
            <div class="container congratulations">
                <div class="congrats">
                    <span class="medium-text">Parabéns, comprovante recebido!</span>
                    <img src="{{asset('assets/images/receive-payment.png')}}">
                    <span class="small-text">Recebemos o seu comprovante de pagamento e os dados do seu agendamento!</span>
                    <span class="small-text">Nosso prazo para validação do comprovante de pagamento é de até 12 horas após o envio do comprovante.</span>
                    <span class="small-text">Não se preocupe o seu horário já está agendado, somente a invalidez do comprovante de pagamento ou dos dados informados podem retirá-lo de você.</span>
                </div>
            </div>
            <div class="container congratulations">
                <div class="confirm-whatsapp">
                    <span class="medium-text">Sem paciência para aguardar as 12 horas?!</span>
                    <span class="small-text">Que tal "agilizar" o processo de analise ? </span>
                    <span class="small-text">Clique no botão abaixo e entre em contato diretamente com nosso whatsapp!</span>
                    <button id="whatsapp-confirm" class="action-button">Confirmar via Whatsapp</button>
                </div>
            </div>
        </section>
    </main>

    <main-footer payments-image="{{asset('assets/images/metodos-pagamento.webp')}}"></main-footer>

</section>

<section id="toast"></section>

<script src="{{asset('assets/js/populate-products.js')}}"></script>
<script src="{{asset('assets/js/functions.js')}}"></script>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Finalizar";
            document.getElementById("nextBtn").classList.toggle('last-step');
        } else {
            document.getElementById("nextBtn").innerHTML = "Próximo";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        if (currentTab >= x.length) {
            const event = new CustomEvent('submitForm');
            document.getElementById("regForm").dispatchEvent(event);
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false:
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }

    document.getElementById("regForm")
        .addEventListener('submit', (e) => e.preventDefault());

    document.getElementById("regForm").addEventListener('submitForm', (e) => {
        e.preventDefault();
        const productId = window.location.pathname.split('/')[1];

        const form = document.getElementById('regForm');
        form.style.display = 'none';

        const loadingSection = document.getElementById('loading');
        loadingSection.appendChild(makeLoading());
        loadingSection.classList.toggle('hidden');

        const customerName = document.getElementById('schedule-customer-name');
        const customerEmail = document.getElementById('schedule-customer-email');
        const customerPhone = document.getElementById('schedule-customer-phone');

        const scheduleDate = document.getElementById('schedule-date');
        const proofPaymentFile = document.getElementById('payment-proof-file-input');

        const formData = new FormData();

        formData.append('productId', productId);
        formData.append('customer[name]', customerName.value);
        formData.append('customer[email]', customerEmail.value);
        formData.append('customer[phone]', customerPhone.value);
        formData.append('schedule[date]', moment(scheduleDate.value).format('YYYY-MM-DD HH:mm'));
        formData.append('schedule[paymentProof]', proofPaymentFile.files[0]);

        createOrder(formData).then((data) => {
            loadingSection.classList.toggle('hidden');
            document.getElementById('proof-file-received').classList.toggle('hidden');
            document.getElementById('cart-card').classList.toggle('hidden');

            toast('Comprovante enviado!', 'success')

            document.getElementById('whatsapp-confirm').addEventListener('click', (e) => {
                toast('Abrindo whatsapp da companhia!', 'success');
                setInterval(() => {
                    window.open(`https://api.whatsapp.com/send/?phone=5585985473412&text=Ol%C3%A1%2C%20acabei%20de%20realizar%20o%20pagamento%20do%20agendamento%20de%20um%20procedimento%20de%20${data.product.name}%20que%20possui%20o%20valor%20de%20R%24%20${formatMonetary(data.total_amount)}.%20Gostaria%20de%20enviar%20meu%20comprovante%20de%20pagamento%20por%20aqui%20tamb%C3%A9m%20para%20agilizar%20a%20valida%C3%A7%C3%A3o%20e%20a%20confirma%C3%A7%C3%A3o%20do%20pagamento%20de%20R%24%20${formatMonetary(data.pre_amount)}%20do%20pr%C3%A9-agendamento.`, '_blank');
                }, 3000)
            })
        });
    });

    document.getElementById('schedule-customer-phone').addEventListener('keypress', (e) => {
        e.target.value = applyNumberMask(e.target.value, '(##) #####-####')
    })

    document.getElementById('copy-paste-pix-action').addEventListener('click', (e) => {
        const pixCopyPaste = document.getElementById('copy-paste-pix-value').value;
        navigator.clipboard.writeText(pixCopyPaste);
    })

    document.getElementById('overlay').addEventListener('click', (e) => hiddenMenu());

    // })
</script>
</body>
</html>
