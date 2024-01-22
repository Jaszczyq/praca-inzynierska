@extends('layouts.app')

@php
    function translateMonths($dateString) {
        $months = [
                    'January' => 'stycznia',
                     'February' => 'lutego',
                     'March' => 'marca',
                     'April' => 'kwietnia',
                     'May' => 'maja',
                     'June' => 'czerwca',
                     'July' => 'lipca',
                     'August' => 'sierpnia',
                     'September' => 'września',
                     'October' => 'października',
                     'November' => 'listopada',
                     'December' => 'grudnia',
        ];

        return str_replace(
            array_keys($months),
            array_values($months),
            $dateString
        );
    }
@endphp

<style>

    #event-list > div:hover {
        transition: all .3s ease-in-out;
        box-shadow: 0 10px 20px silver;
    }

    #sort > option, #order > option {
        font-family: "Source Sans Pro", sans-serif;
        font-size: 13px;
    }
</style>
@section('content')
    <div class="container">
        <div class="bg-gray-800 text-white p-4 text-center rounded-t">
            <h1 class="text-2xl font-bold">{{ __('refunds.list') }}</h1>
        </div>

        <div class="card bg-white border-none">
            <ul id="event-list" class="list-group" style="border:none">
                @forelse ($refundedTickets as $refund)
                    @php
                        $event = $refund->ticket->event;
                        $ticket = $refund->ticket;
                    @endphp
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg"
                         style="border-radius: 5px; margin: 10px 0">
                        <div class="wyd-szukaj-table">
                            <div
                                class="table-row d-flex align-items-start rounded-lg overflow-hidden w-full text-center line-height-0">

                                <div class="row-cell cell-wyd-lista-1 me-3 text-center p-2 my-auto">

                                    <div class="text-center p-4 w-44 flex flex-col justify-center h-full">
                                        <div class="no-warp linia-1">
                                            <b>{{ translateMonths($event->date->format('j F Y')) }}</b>
                                        </div>
                                        <div class="no-warp linia-2">
                                            {{ __('events.hour') }} {{ substr($event->time, 0, strlen($event->time) - 3) }}
                                        </div>
                                        <div>
                                            <span class="no-warp linia-3">
                                                <b>Bilet {{ $ticket->ticketType->name }}</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="row-cell cell-wyd-lista-2 me-3 align-middle p-0 line-height-0 text-xs my-auto">
                                    <a href="#"
                                       title="{{ $event->title }}">
                                        <div
                                            style="width: 163px; height: 110px; overflow: hidden; border-radius: 10px; margin: 10px 0;">
                                            <img
                                                src="{{ $event->image }}" alt="{{ $event->title }}"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;"/>
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="row-cell cell-wyd-lista-3 me-3 my-auto p-4 text-left relative overflow-hidden table-cell align-middle line-height-normal"
                                    style="width: 30%">
                                    <div class="flex flex-col justify-center h-full">
                                        <div><b>{{ $event->title }}</b></div>
                                        <div>{{ $event->categories->pluck('name')->join(', ') }}</div>
                                    </div>
                                </div>
                                <div
                                    class="row-cell cell-wyd-lista-4 me-3 my-auto p-4 w-56 table-cell align-middle line-height-normal text-center"
                                    style="width: 25%">
                                    <div class="flex flex-col justify-center h-full">
                                        <div><b>{{ $event->city }}</b></div>
                                        <div>{{ $event->place }}</div>
                                    </div>
                                </div>
                                <div
                                    class="row-cell cell-wyd-lista-5 my-auto p-4 w-44 table-cell align-middle line-height-normal text-center">
                                    <div class="flex flex-col justify-center h-full">
                                        <a href="#" onclick="openModal({{ $refund->id }})"
                                           class="btn btn-primary">{{ __('refunds.refunds_manage') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-center">{{ __('refunds.no_refunds') }}</p>
                @endforelse
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="refundTicketModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Jaka decyzja w sprawie zwrotu?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Wciśnij odpowiednią opcję na dole.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="sendRefundData('accept')" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Zatwierdź
                    </button>
                    <button type="button" onclick="sendRefundData('decline')" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Odmów
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Anuluj
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var selectedRefund = null;

        function openModal(id) {
            var modal = document.getElementById('refundTicketModal');
            modal.classList.remove('hidden');

            selectedRefund = id;
        }

        function closeModal() {
            var modal = document.getElementById('refundTicketModal');
            modal.classList.add('hidden');
        }

        function sendRefundData(decision) {
            var data = {
                'refund_id': selectedRefund,
                'accepted': decision === 'accept',
                'xsrf_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            fetch('{{ route('refunds.refund') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': data.xsrf_token
                },
                body: JSON.stringify(data)
            }).then(response => {
                return response.json();
            }).then(data => {
                window.location.reload();
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

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
