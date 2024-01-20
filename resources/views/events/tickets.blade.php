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
            <h1 class="text-2xl font-bold">{{ __('events.my_tickets') }}</h1>
        </div>

        <div class="card bg-white border-none">
            <div class="card-body  border-gray-200 rounded-b">
                <div class="flex justify-between items-center">
                    <div class="space-x-2 flex justify-start items-center w-full">
                        <div class="flex justify-start items-center w-full">
                            <select name="sort" id="sort"
                                    class="mr-2 min-w-[100px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                    onchange="sort()">
                                <option value="date" selected="">{{ __('events.sort_date') }}</option>
                                <option value="title">{{ __('events.sort_title') }}</option>
                                <option value="city">{{ __('events.sort_city') }}</option>
                            </select>
                            <select name="order" id="order"
                                    class="w-[100px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                    onchange="sort()">
                                <option value="asc" selected="">&#x25B2; {{ __('events.sort_up') }}</option>
                                <option value="desc">&#x25BC; {{ __('events.sort_down') }}</option>
                            </select>
                        </div>
                    </div>
                </div>


                <script>
                    function toggleCheckboxList() {
                        var checkboxListDiv = document.getElementById('checkboxList');
                        if (checkboxListDiv.classList.contains('hidden')) {
                            checkboxListDiv.classList.remove('hidden');
                        } else {
                            checkboxListDiv.classList.add('hidden');
                        }
                    }

                    function sort() {
                        console.log("Change event triggered");
                        fetch('/tickets/sort/' + $('#sort').val() + '/' + $('#order').val())
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('event-list').innerHTML = data;
                            });
                    }
                </script>
            </div>

            <ul id="event-list" class="list-group" style="border:none">
                @forelse ($tickets as $ticket)
                    @php $event = $ticket->event; @endphp
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
                                                <b>{{ $event->ticketType }}</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="row-cell cell-wyd-lista-2 me-3 align-middle p-0 line-height-0 text-xs my-auto">
                                    <a title="{{ $event->title }}">
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
                                        <div>Bilet {{ $ticket->ticketType->name }}, <b>{{ $event->price }} zł</b></div>
                                        <!-- check if time to event is more than 30 minutes -->
                                        @php
                                            $eventStart = \Carbon\Carbon::parse(explode(' ', $event->date)[0] . ' ' . $event->time);
                                            $now = \Carbon\Carbon::now();
                                        @endphp

                                        @if($now->lessThan($eventStart) && $now->diffInMinutes($eventStart) > 30)
                                        <a href="{{ route('tickets.refund', ['id' => $ticket->id]) }}"
                                           class="btn btn-primary">{{ __('events.refund') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-center">{{ __('events.no_events_day') }}</p>
                @endforelse
            </ul>
        </div>
    </div>

    @component('events.modal_details', ['categories' => $categories])
    @endcomponent
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function searchEvents() {
            var searchCity = $("#search-city").val();
            var searchTitle = $("#search-title").val();

            var searchQuery = "";
            if (searchCity) {
                searchQuery += "?city=" + searchCity;
            }
            if (searchTitle) {
                if (searchQuery) {
                    searchQuery += "&title=" + searchTitle;
                } else {
                    searchQuery += "?title=" + searchTitle;
                }
            }

            $.ajax({
                url: "/events/search" + searchQuery,
                method: "GET",
                success: function (response) {
                    $("#event-list").html(response);
                }
            });
        }

        $(document).ready(function () {
            let timeout;

            $("#search-title").on("keyup", function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    searchEvents();
                }, 300);
            });

            $("#search-city").on("keyup", function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    searchEvents();
                }, 300);
            });
        });
    </script>

    <script>
        var buyUrlTemplate = "{{ route('seats', ':id') }}";

        var currentBuyUrl = buyUrlTemplate.replace(':id', -1);

        var modalDetails = document.getElementById("modal_details");

        const options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};

        document.getElementById("buyButton").addEventListener("click", function () {
            window.location.href = currentBuyUrl;
        });

        function openModalDetails(id) {
            modalDetails.style.display = "block";

            fetch('/events/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("event_title").textContent = data.title;
                    document.getElementById("event_description").textContent = data.description;
                    document.getElementById("event_city").textContent = data.city;
                    document.getElementById("event_place").textContent = data.place;
                    document.getElementById("event_date").textContent = new Date(data.date).toLocaleDateString('pl-PL', options);
                    document.getElementById("event_time").textContent = data.time;
                    document.getElementById("event_categories").textContent = data.category;

                    /*var ticketPrices = data.ticket_prices;

                    for (var i = 0; i < ticketPrices.length; i++) {
                        var ticketTypeId = ticketPrices[i].id;
                        var ticketValue = ticketPrices[i].pivot.price;

                        document.getElementById("ticket_types[" + ticketTypeId + "][price]").value = ticketValue;
                    }*/

                    currentBuyUrl = buyUrlTemplate.replace(':id', id);
                });
        }

        function closeModalDetails() {
            modalDetails.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modalDetails) {
                modalDetails.style.display = "none";
            }
        }
    </script>

    @component('events.modal_create', ['categories' => $categories])
    @endcomponent
    <script>
        var modal = document.getElementById("modal_create");

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
