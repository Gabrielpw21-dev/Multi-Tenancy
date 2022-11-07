<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('dashboard.store') }}" method="post" id="form">
                        @csrf
                        <input type="text" name="card-hold-name" id="card-hold-name" placeholder="Nome no Cartão" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
<br>
<br>
                        <div id="card-element"></div>

                        <div class="col-span-6 sm:col-span-4 py-2">
                            <button class="inline-flex justify-center"
                                    data-secret="{{ $intent->client_secret }}"
                                    id="btn-payment"
                                    style="background:rgb(153, 49, 250); color:rgb(252, 252, 252); padding:8px 25px; border-radius:15px;"
                                    type="submit">Fazer pagamento</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const stripe = Stripe("{{ config('cashier.key') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');
    // subscription payment
    const form = document.getElementById('form')
    const cardHolderName = document.getElementById('card-holder-name')
    const cardButton = document.getElementById('card-buttom')
    const clientSecret = cardButton.dataset.secret
    const showErrors = document.getElementById('show-errors')
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        // Disable button
        cardButton.classList.add('cursor-not-allowed')
        cardButton.firstChild.data = 'Validando'
        // reset errors
        showErrors.innerText = ''
        showErrors.style.display = 'none'
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );
        if (error) {
            console.log(error)
            showErrors.style.display = 'block'
            showErrors.innerText = (error.type == 'validation_error') ? error.message : 'Dados inválidos, verifique e tente novamente!'
            cardButton.classList.remove('cursor-not-allowed')
            return;
        }
        let token = document.createElement('input')
        token.setAttribute('type', 'hidden')
        token.setAttribute('name', 'token')
        token.setAttribute('value', setupIntent.payment_method)
        form.appendChild(token)
        form.submit()
    })
    </script>
