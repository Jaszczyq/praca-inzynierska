@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="w-full max-w-xl mx-auto bg-white rounded p-5">
            <div class="mb-5">
                <h2 class="text-center font-bold text-2xl mb-3">Metoda płatności</h2>
                <div class="flex justify-between space-x-4 p-2 mx-auto">
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/Alior.png') }}" alt="Alior Bank" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/Bank Pekao.png') }}" alt="Bank Pekao" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/BNP Paribas.png') }}" alt="BNP Paribas" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/Credit Agricole.png') }}" alt="Credit Agricole" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                </div>
                <div class="flex justify-between space-x-4 p-2 mx-auto">
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/SGB.png') }}" alt="SGB" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/ING.png') }}" alt="ING" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/mBank.png') }}" alt="mBank" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/Millenium.png') }}" alt="Credit Agricole" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                </div>
                <div class="flex justify-between space-x-4 mx-auto p-2 mb-4">
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/PBS.png') }}" alt="PBS" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/PKO Bank Polski.png') }}" alt="PKO Bank Polski" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/Visa.png') }}" alt="Visa" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                    <div class="w-1/5 payment-method">
                        <div class="border rounded p-2 text-center h-20 w-20 mx-auto">
                            <img src="{{ asset('images/logotypy_bankow/MC.png') }}" alt="MC" class="h-full w-full object-contain mx-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-5 flex justify-center">
                <button id="pay-button" class="disabled w-64 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mx-auto" disabled type="button">
                    Zapłać
                </button>
            </div>
        </div>
    </div>

    <style>
        .payment-method {
            box-sizing: border-box;  /* Dodaj tę linię */
            cursor: pointer;
        }

        .payment-method:hover > .border {
            border-color: lightgreen !important;
            border-width: 1px;
            border-radius: 0.25rem;
            text-align: center;
        }
        .payment-method.selected > .border {
            border-color: green !important;
            border-style: solid;
            border-width: 1px;
        }

        button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }
    </style>

    <script>
        document.getElementById("pay-button").addEventListener("click", payButton);

        // select payment method on click
        const paymentMethods = document.querySelectorAll('.payment-method')

        var ticketsData = loadFromLocalstorage('selectedTickets');
        var price = 0;
        ticketsData.forEach(ticket => {
            price += parseFloat(ticket.price);
        });

        paymentMethods.forEach(paymentMethod => {
            paymentMethod.addEventListener('click', () => {
                paymentMethods.forEach(paymentMethod => {
                    paymentMethod.classList.remove('selected')
                });

                paymentMethod.classList.add('selected')
                document.getElementById('pay-button').disabled = false;
            })
        });

        function loadFromLocalstorage(key) {
            return JSON.parse(localStorage.getItem(key));
        }

        function payButton() {
            var url = "/payment/confirm";

            //get selected payment method
            var selectedPaymentMethod = document.querySelector('.payment-method.selected');

            if (selectedPaymentMethod === null) {
                console.log('No payment method selected');
            }
            else {
                var paymentMethod = selectedPaymentMethod.querySelector('img').alt;

                var data = {
                    paymentMethod: paymentMethod,
                    eventId: {{ $event->id }},
                    price: price
                };

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                }).then(response => {
                    return response.json();
                }).then(data => {
                    console.log(data);
                    location.replace(data.url);
                })
            }
        }
    </script>
@endsection
