@extends('layouts.app')

@section('content')

<div class="container mx-auto p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-5">
                <div class="text-center">
                    <h1 class="text-gray-600 font-bold text-2xl mb-1">Zwrot Biletu</h1>
                </div>
                <form id="refundForm" class="mt-4" action="#">
                    @csrf
                    <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $ticket->id }}" />
                    <div>
                        <label class="block" for="ticketPrice">Cena biletu</label>
                        <input type="text" placeholder="Wpisz cenę biletu" name="ticketPrice" id="ticketPrice" value="{{ $ticket->price }}" disabled class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>
                    <div class="mt-4">
                        <label class="block" for="email">Adres Email</label>
                        <input type="email" placeholder="Wpisz swój adres email" name="email" id="email" value="{{ Auth::user()->email }}" disabled class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Wyślij</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="refundTicketModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Czy aby na pewno chcesz zwrócić ten bilet?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="sendRefundData()" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Zwróć
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Anuluj
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal() {
        var modal = document.getElementById('refundTicketModal');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        var modal = document.getElementById('refundTicketModal');
        modal.classList.add('hidden');
    }

    function sendRefundData() {
        var data = {
            'ticket_id': document.getElementById('ticket_id').value,
            'email': document.getElementById('email').value,
            'ticketPrice': document.getElementById('ticketPrice').value,
            'xsrf_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        fetch('{{ route('tickets.refundData') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data.xsrf_token
            },
            body: JSON.stringify(data)
        }).then(response => {
            return response.json();
        }).then(data => {
            window.location.replace('{{ route('tickets.showRefundInfo') }}');
        })
    }

    document.getElementById("refundForm").addEventListener('submit', function(event) {
        event.preventDefault();
        openModal();
    });

    window.onclick = function(event) {
        var modal = document.getElementById('refundTicketModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    }
</script>

@endsection
