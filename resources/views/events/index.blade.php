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

@section('content')
    <div class="container">
        <div class="card bg-white" style="border: none">
            <div class="card-body" style="border: 1px solid #e2e8f0; border-radius: 5px">
                <h1 class="text-2xl font-bold">{{ __('events.events') }}</h1>
                <div class="p-6 space-y-4">
                    <div class="pb-4 bg-white">
                        <label for="table-search" class="sr-only"></label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg
"
                                     fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="search"
                                   class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="{{ __('events.search') }}" style="padding-left:35px !important;">
                        </div>
                    </div>

                    <div>
                        <button onclick="toggleCheckboxList()"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow hover:bg-blue-700 focus:outline-none">{{ __('events.category') }}</button>
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
                    </div>
                </div>

{{--                <div class="dropdown">--}}
{{--                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"--}}
{{--                            data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                        Sortuj--}}
{{--                    </button>--}}
{{--                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                        <li><a class="dropdown-item" href="#" data-sort="date">Po dacie</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#" data-sort="title">Pod nazwą</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#" data-sort="city">Po miejscowości</a></li>--}}
{{--                    </ul>--}}
{{--                    <i class="bi bi-arrow-up" data-order="asc"></i>--}}
{{--                    <i class="bi bi-arrow-down" data-order="desc"></i>--}}
{{--                </div>--}}

                <script>
                    var currentSort = 'date';
                    var currentOrder = 'asc';

                    $('.dropdown-item').click(function(e) {
                        e.preventDefault();
                        currentSort = $(this).data('sort');
                        sort();
                    });

                    $('.bi-arrow-up, .bi-arrow-down').click(function(e) {
                        currentOrder = $(this).data('order');
                        sort();
                    });

                    function sort() {
                        var url = '{{ route('events.index') }}' + '?sort=' + currentSort + '&order=' + currentOrder;
                        window.location.href = url;
                    }

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
                </script>

                <ul id="event-list" class="list-group" style="border:none">
                    @forelse ($events as $event)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg"
                             style="border: 1px solid #e2e8f0; border-radius: 5px; margin: 10px 0">
                            <div class="wyd-szukaj-table">
                                <div
                                    class="table-row d-flex align-items-start border-2 rounded-lg overflow-hidden w-full text-center line-height-0">

                                    <div class="row-cell cell-wyd-lista-1 me-3 text-center p-2 my-auto">

                                        <div class="text-center p-4 w-44 flex flex-col justify-center h-full">
                                            <div class="no-warp linia-1">
                                                <b>{{ translateMonths($event->date->format('j F Y')) }}</b>
                                            </div>
                                            <div class="no-warp linia-2">
                                                godz. {{ substr($event->time, 0, strlen($event->time) - 3) }}
                                            </div>
                                            <div>
        <span class="no-warp linia-3">
            <b>{{ $event->ticketType }}</b>
        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-cell cell-wyd-lista-2 me-3 align-middle p-0 line-height-0 text-xs my-auto">
                                        <a href="{{ route('event.details', ['id' => $event->id]) }}"
                                           title="{{ $event->title }}">
                                            <div style="width: 163px; height: 110px; overflow: hidden; border-radius: 10px; margin: 10px 0;">
                                                <img onclick="openModalDetails({{ $event->id }}); event.preventDefault();"
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
                                            <a href="{{ route('seats') }}" class="btn btn-success">{{ __('events.buy') }}</a>
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
            $(document).ready(function () {
                let timeout;

                $(document).ready(function () {
                    let timeout;

                    $("#search").on("keyup", function () {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            var searchQuery = $(this).val();

                            if (searchQuery === '') {
                                searchQuery = 'all';
                            }

                            $.ajax({
                                url: "/events/search/" + searchQuery,
                                method: "GET",
                                success: function (response) {
                                    $("#event-list").html(response);
                                }
                            });
                        }, 300);
                    });
                });
            });
        </script>

        <script>
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
                    });
            }

            function closeModalDetails() {
                modalDetails.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == modalDetails) {
                    modalDetails.style.display = "none";
                }
            }
        </script>

        <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

@endsection
