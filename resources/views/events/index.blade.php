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
            <h1 class="text-2xl font-bold">{{ __('events.events') }}</h1>
        </div>

        <div class="card bg-white border-none">
        <div class="card-body  border-gray-200 rounded-b">
            <div class="flex justify-between items-center">
                <div class="p-6 space-y-4">
                    <!-- Flex container -->
                    <div class="flex space-x-4 bg-white">
                        <!-- First search bar -->
                        <div class="relative mt-1 flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="search-title" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 w-full" placeholder="{{ __('events.search_title') }}" style="padding-left:35px !important;">
                        </div>
                        <!-- Second search bar -->
                        <div class="relative mt-1 flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500"
                                     viewBox="0 0 640 512">
                                    <path
                                        fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H304h32 96H592c26.5 0 48-21.5 48-48V240c0-26.5-21.5-48-48-48H480V48zm96 320v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM240 416H208c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zM128 400c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM560 256c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H528c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32zM256 176v32c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM112 160c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32zM256 304c0 8.8-7.2 16-16 16H208c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32zM112 320H80c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16zm304-48v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V272c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16zM400 64c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V80c0-8.8 7.2-16 16-16h32zm16 112v32c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16z"/>
                                </svg>
                            </div>
                            <input type="text" id="search-city" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 w-full" placeholder="{{ __('events.search_city') }}" style="padding-left:35px !important;">
                        </div>
                    </div>
                </div>

                    @can('isOrganizer')
                        <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700focus:outline-none dark:focus:ring-blue-800"
                                onclick="openModal(); document.querySelector('.dropdown-menu.dropdown-menu-end').style.display = 'none'; event.preventDefault();">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white"
                                     viewBox="0 0 448 512">
                                    <path
                                        fill="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                                </svg>
                            </div>
                            <span class="pl-2">{{ __('events.create') }}</span>
                        </button>
                    @endcan
                </div>

                    <div class="p-6 space-y-4">
                        <div class="pb-4 bg-white">
                            <label for="table-search" class="sr-only"></label>

                            <div class="space-x-2 flex justify-start items-center w-full">
                            <button onclick="toggleCheckboxList()"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 512 512" stroke="currentColor">
                                    <!-- Zastąp poniższe ścieżki odpowiednimi dla Twojego SVG -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>
                                {{ __('events.category') }}
                            </button>
                            <div id="checkboxList" class="hidden mt-2 bg-white border rounded p-2">
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($categories as $category)
                                        <div class="flex items-center ml-2 mb-2">
                                            <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                                                   value="{{ $category->id }}" onchange="filterEvents()">
                                            <label for="category_{{ $category->id }}"
                                                   class="ml-2 text-sm font-medium text-gray-900">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

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

                        function filterEvents() {
                            // Pobierz wszystkie kategorie
                            var categories = document.querySelectorAll('input[name="categories[]"]:checked');

                            // Zbierz ID wybranych kategorii
                            var selectedCategories = Array.from(categories).map(function (category) {
                                return category.value;
                            });

                            // Utwórz parametry URL
                            var params = new URLSearchParams();
                            for (var i = 0; i < selectedCategories.length; i++) {
                                params.append('categories[]', selectedCategories[i]);
                            }

                            // Wyślij żądanie AJAX do serwera
                            fetch('/events/filter?' + params.toString())
                                .then(response => response.text())
                                .then(data => {
                                    // Aktualizuj listę wydarzeń na stronie
                                    document.getElementById('event-list').innerHTML = data;
                                });
                        }

                        function sort() {
                            console.log("Change event triggered");
                            fetch('/events/sort/' + $('#sort').val() + '/' + $('#order').val())
                                .then(response => response.text())
                                .then(data => {
                                    document.getElementById('event-list').innerHTML = data;
                                });
                        }
                    </script>
                </div>

                <ul id="event-list" class="list-group" style="border:none">
                    @forelse ($events as $event)
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
                                        <a href="{{ route('event.details', ['id' => $event->id]) }}"
                                           title="{{ $event->title }}">
                                            <div
                                                style="width: 163px; height: 110px; overflow: hidden; border-radius: 10px; margin: 10px 0;">
                                                <img
                                                    onclick="openModalDetails({{ $event->id }}); event.preventDefault();"
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
                                            <a href="{{ route('seats', ['id' => $event->id]) }}"
                                               class="btn btn-success">{{ __('events.buy') }}</a>
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
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

@endsection
