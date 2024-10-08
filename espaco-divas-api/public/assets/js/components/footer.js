class Footer extends HTMLElement {
    connectedCallback() {
        const paymentsImage = this.getAttribute('payments-image');

        this.innerHTML = `
           <footer class="container">
        <section class="navigation">
            <a><span>Termos e Serviço</span></a>
            <a><span>Política de Privacidade</span></a>
            <a ><span onclick="cancelTerm()">Cancelamento e reembolso</span></a>
            <div id="cancel-term" class="cancel-term">
                <h1>Política de Cancelamento de Serviço</h1>
                <p>Agradecemos por escolher nossos serviços. Para garantir uma experiência justa e transparente, estabelecemos a seguinte política de cancelamento:</p>

                <h2>Prazo para Cancelamento</h2>
                <p>O cliente pode solicitar o cancelamento do serviço até 2 (dois) dias antes da data programada. Cancelamentos feitos dentro desse prazo não serão reembolsados.</p>

                <h2>Reembolso</h2>
                <p>O reembolso será efetuado apenas se o cancelamento for realizado dentro do prazo estabelecido. O valor total pago será reembolsado em até 7 (sete) dias úteis após a confirmação do cancelamento.</p>

                <h2>Exceções</h2>
                <p>Não haverá reembolso em casos de não comparecimento ou cancelamentos feitos após o prazo de 2 dias.</p>

                <h2>Alterações de Data</h2>
                <p>Caso o cliente deseje alterar a data do serviço, essa solicitação deve ser feita com pelo menos 2 (dois) dias de antecedência. Faremos o possível para atender a nova data solicitada, sujeita à disponibilidade.</p>

            </div>
        </section>

        <section class="newsletter">
            <form id="newsletter-subcription">
                <label for="newsletter-mail">Promoções</label>
                <div class="input">
                    <input type="email" id="newsletter-mail" class="input-entry" placeholder="Digite seu melhor email">
                    <button id="newsletter-subscription-button" form="newsletter-subcription" type="submit">Inscrever</button>
                </div>
            </form>
        </section>
        <section class="hours-work">
            <span class="title">Horário de Funcionamento</span>
            <span class="info">Segunda a Sexta: 08:00 - 19:00</span>
            <span class="info">Sábado: 08:00 - 17:00</span>
        </section>
        <section class="container medias">
            <div class="social">
                <a><i class="fa-brands fa-instagram"></i></a>
                <a href="https://api.whatsapp.com/send/?phone=5585985473412&text=Ola%2C%20Espa%C3%A7o%20divas.%20Vim%20pelo%20site%20e%20gostaria%20de%20algumas%20informa%C3%A7%C3%B5es." target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
            </div>

            <div class="payments">
                <img src="${paymentsImage}">
            </div>
        </section>
    </footer>
        `
    }
}

customElements.define('main-footer', Footer);
