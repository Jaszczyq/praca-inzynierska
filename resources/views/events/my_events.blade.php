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
            <h1 class="text-2xl font-bold">{{ __('events.my_events') }}</h1>
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

                    <div class="space-x-2 flex justify-start w-fit">
                        <button onclick="toggleCheckboxList()"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 512 512" stroke="currentColor">
                                <!-- Zastąp poniższe ścieżki odpowiednimi dla Twojego SVG -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>
                            {{ __('events.category') }}
                        </button>
                        <div id="checkboxList" class="scale-0 absolute z-10 bg-white border rounded px-4 py-2 transition-transform duration-300 origin-top m-0" style="margin-top: 3.5rem !important;">
                            <div class="grid grid-cols-1 gap-2">
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

                <script>
                    function toggleCheckboxList() {
                        var checkboxList = document.getElementById('checkboxList');
                        if (checkboxList.classList.contains('scale-0')) {
                            checkboxList.classList.remove('scale-0');
                            checkboxList.classList.add('scale-100');
                        } else {
                            checkboxList.classList.remove('scale-100');
                            checkboxList.classList.add('scale-0');
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

                        var paramsString = params.toString();

                        // Wyślij żądanie AJAX do serwera
                        fetch('/events/filter?myEvents=true' + (paramsString !== '' ? '&' + paramsString : ''))
                            .then(response => response.text())
                            .then(data => {
                                // Aktualizuj listę wydarzeń na stronie
                                document.getElementById('my-event-list').innerHTML = data;
                            });
                    }

                    function sort() {
                        console.log("Change event triggered");
                        fetch('/events/sort/' + $('#sort').val() + '/' + $('#order').val())
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('my-event-list').innerHTML = data;
                            });
                    }
                </script>
            </div>

            <ul id="my-event-list" class="list-group" style="border:none">
                @foreach ($currentEvents->merge($archivedEvents)->sortBy('date') as $event)
                    <div class="{{ $event->date->isPast() ? 'bg-gray-200' : '' }}">
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
                                        class="row-cell cell-wyd-lista-5 my-auto p-4 w-30 table-cell align-middle line-height-normal text-center">
                                        <div class="flex flex-row justify-center h-full">
                                            @if ($event->date->isFuture() || ($event->date->isToday() && $event->time >= \Carbon\Carbon::now()->format('H:i')))
                                                <a href="#"
                                                   onclick="openModalEdit({{ $event->id }}); event.preventDefault();"
                                                   class="bg-white border-white btn btn-primary edit-button mr-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                         viewBox="0 0 512 512">
                                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path
                                                            d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                                                    </svg>
                                                </a>
                                                <a href="#"
                                                   onclick="openModalDelete({{ $event->id }}); event.preventDefault();"
                                                   class="btn border-white bg-white btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                         viewBox="0 0 448 512">
                                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <path
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="#"
                                                   onclick="openModalRestore({{ $event->id }}); event.preventDefault();"
                                                   class="btn bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18"
                                                         viewBox="0 0 576 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path
                                                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function searchEvents() {
            var searchCity = $("#search-city").val();
            var searchTitle = $("#search-title").val();

            var searchQuery = "?mySearch=true";
            if (searchCity) {
                searchQuery += "&city=" + searchCity;
            }
            if (searchTitle) {
                if (searchQuery) {
                    searchQuery += "&title=" + searchTitle;
                } else {
                    searchQuery += "&title=" + searchTitle;
                }
            }

            $.ajax({
                url: "/events/search" + searchQuery,
                method: "GET",
                success: function (response) {
                    $("#my-event-list").html(response);
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

    @component('events.modal_create', ['categories' => $categories, 'halls' => $halls])
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Zakładamy, że masz przycisk edycji dla każdego wydarzenia z atrybutem data-id ustawionym na id wydarzenia
        $('.edit-button').on('click', function () {
            var eventId = $(this).data('id');
            $.ajax({
                url: '/events/' + eventId + '/edit', // Zaktualizuj tę ścieżkę do ścieżki edycji w twoim API
                method: 'GET',
                success: function (data) {
                    // Zakładamy, że twoje API zwraca formularz HTML z wypełnionymi danymi wydarzenia
                    $('#modal_edit .modal-content').html(data);
                    $('#modal_edit').show();
                }
            });
        });
    </script>
    @component('events.modal_edit', ['categories' => $categories, 'halls' => $halls])
    @endcomponent
    <script>
        var modalEdit = document.getElementById("modal_edit");

        var edit_url = "{{ route('event.update', ':id') }}";

        document.getElementById("eventEditForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var url = edit_url.replace(':id', document.getElementById("id_event").value);

            fetch(url, {
                method: 'POST',
                body: new FormData(this)
            }).then(function (response) {
                closeModalEdit();
                location.reload();
            }).catch(function (error) {
                console.log(error);
            })
        });

        function openModalEdit(id) {
            modalEdit.style.display = "block";

            fetch('/events/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("id_event").value = data.id;
                    document.getElementById("titleEdit").value = data.title;
                    document.getElementById("descriptionEdit").value = data.description;
                    document.getElementById("cityEdit").value = data.city;
                    document.getElementById("placeEdit").value = data.place;
                    var selectElement = document.getElementById("categoryEdit");
                    selectElement.value = data.category_id;
                    document.getElementById("dateEdit").value = data.date.split('T')[0];
                    document.getElementById("timeEdit").value = data.time;
                    document.getElementById("hallEdit").value = data.hall_id;

                    //console.log(data);
                    var ticketPrices = data.ticket_types;

                    for (var i = 0; i < ticketPrices.length; i++) {
                        var ticketTypeId = ticketPrices[i].id;
                        var ticketValue = ticketPrices[i].pivot.price;

                        //console.log(ticketTypeId);
                        //console.log(ticketValue);
                        //console.log(document.getElementsByName("ticket_types[" + ticketTypeId + "][price]")[1]);

                        document.getElementsByName("ticket_types[" + ticketTypeId + "][price]")[1].value = ticketValue;
                    }
                });
        }

        function closeModalEdit() {
            modalEdit.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modalEdit) {
                modalEdit.style.display = "none";
            }
        }
    </script>

    @component('events.modal_restore', ['categories' => $categories, 'halls' => $halls])
    @endcomponent
    <script>
        var modalRestore = document.getElementById("modal_restore");

        var edit_url = "{{ route('event.update', ':id') }}";

        document.getElementById("eventRestoreForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var url = edit_url.replace(':id', document.querySelectorAll("[id=id_event]")[1].value);

            fetch(url, {
                method: 'POST',
                body: new FormData(this)
            }).then(function (response) {
                closeModalRestore();
                location.reload();
            }).catch(function (error) {
                console.log(error);
            })
        });

        function openModalRestore(id) {
            modalRestore.style.display = "block";

            fetch('/events/' + id)
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll("[id=id_event]")[1].value = data.id;
                    document.querySelectorAll("[id=titleEdit]")[1].value = data.title;
                    document.querySelectorAll("[id=descriptionEdit]")[1].value = data.description;
                    document.querySelectorAll("[id=cityEdit]")[1].value = data.city;
                    document.querySelectorAll("[id=placeEdit]")[1].value = data.place;
                    document.querySelectorAll("[id=hallEdit]").value = data.hall_id;


                    var ticketPrices = data.ticket_types;

                    for (var i = 0; i < ticketPrices.length; i++) {
                        var ticketTypeId = ticketPrices[i].id;
                        var ticketValue = ticketPrices[i].pivot.price;

                        //console.log(ticketTypeId);
                        //console.log(ticketValue);
                        //console.log(document.getElementsByName("ticket_types[" + ticketTypeId + "][price]")[1]);

                        document.getElementsByName("ticket_types[" + ticketTypeId + "][price]")[2].value = ticketValue;
                    }

                    var selectElement = document.querySelectorAll("[id=categoryEdit]")[1];
                    selectElement.value = data.category_id;
                    //document.querySelectorAll("[id=dateEdit]")[1].value = data.date.split('T')[0];
                    //document.querySelectorAll("[id=timeEdit]")[1].value = data.time;
                });
        }

        function closeModalRestore() {
            modalRestore.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modalRestore) {
                modalRestore.style.display = "none";
            }
        }
    </script>

    @component('events.modal_delete')
    @endcomponent
    <script>
        var modalDelete = document.getElementById("modal_delete");

        var delete_url = "{{ route('event.delete', ':id') }}";

        function openModalDelete(id) {
            modalDelete.style.display = "block";

            fetch('/events/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("id_event_delete").value = data.id;
                    document.getElementById("eventNameDelete").innerText = data.title;
                    document.getElementById("event_title_delete").innerText = data.title;
                });
        }

        function closeModalDelete() {
            modalDelete.style.display = "none";
        }

        document.getElementById("eventDeleteForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var url = delete_url.replace(':id', document.getElementById("id_event_delete").value);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: new URLSearchParams({
                    '_method': 'DELETE'
                })
            }).then(function (response) {
                console.log(response);
                closeModalDelete();
                location.reload();
            }).catch(function (error) {
                console.log(error);
            })
        });

        window.onclick = function (event) {
            if (event.target === modalDelete) {
                modalDelete.style.display = "none";
            }
        }
    </script>

    @component('events.modal_details', ['categories' => $categories])
    @endcomponent
    <script>
        var modalDetails = document.getElementById("modal_details");

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
                    document.getElementById("event_hall").textContent = data.hall != null ? data.hall.name : "Brak danych";
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

    <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

@endsection
