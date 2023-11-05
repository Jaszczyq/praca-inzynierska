@extends('layouts.app')

@php
    function translateMonths($dateString) {
        $months = [
            'January' => 'Styczeń',
            'February' => 'Luty',
            'March' => 'Marzec',
            'April' => 'Kwiecień',
            'May' => 'Maj',
            'June' => 'Czerwiec',
            'July' => 'Lipiec',
            'August' => 'Sierpień',
            'September' => 'Wrzesień',
            'October' => 'Październik',
            'November' => 'Listopad',
            'December' => 'Grudzień',
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
        @can('isOrganizer')
            <div class="mb-3 text-end">
                <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>
            </div>
        @endcan

        <div class="card" style="border: none">
            <div class="card-body" style="border: 1px solid #e2e8f0; border-radius: 5px">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="pb-4 bg-white">
                        <label for="table-search" class="sr-only"></label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="search"
                                   class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Wyszukaj wydarzenie" style="padding-left:35px !important;">
                        </div>
                    </div>

                    <div class="form-group flex items-center p-2 rounded">
                        <select name="category_id" id="category_id" class="form-control w-fit"
                                onchange="filterEvents(this)">
                            <option
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                value="">Rodzaj wydarzenia
                            </option>
                            @foreach($categories as $category)
                                <option class="w-full ml-2 text-sm font-medium text-gray-900 rounded"
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <ul id="event-list" class="list-group" style="border:none">
                    @forelse ($events as $event)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg"
                             style="border: 1px solid #e2e8f0; border-radius: 5px; margin: 10px 0">
                            <div class="wyd-szukaj-table">
                                <div
                                    class="table-row d-flex align-items-start border-2 rounded-lg overflow-hidden w-full text-center line-height-0">

                                    <div class="row-cell cell-wyd-lista-1 me-3 text-center p-2 my-auto">

                                        <div class="text-center p-4 w-36 flex flex-col justify-center h-full">
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
                                    <div
                                        class="row-cell cell-wyd-lista-2 me-3 align-middle p-0 line-height-0 text-xs my-auto">
                                        <a href="{{ route('event.details', ['id' => $event->id]) }}"
                                           title="{{ $event->title }}">
                                            <img src="{{ $event->image }}" alt="{{ $event->title }}"
                                                 class="mx-auto my-auto" width="163px" height="110px"/>
                                        </a>
                                    </div>
                                    <div
                                        class="row-cell cell-wyd-lista-3 me-3 my-auto p-4 text-left relative overflow-hidden table-cell align-middle line-height-normal"
                                        style="width: 30%">
                                        <div class="flex flex-col justify-center h-full">
                                            <div><b>{{ $event->title }}</b></div>
                                            <div>{{ $event->description }}</div>
                                        </div>
                                    </div>
                                    <div
                                        class="row-cell cell-wyd-lista-4 me-3 my-auto p-4 w-56 table-cell align-middle line-height-normal text-center"
                                        style="width: 25%">
                                        <div class="flex flex-col justify-center h-full">
                                            <div><b>{{ $event->place }}</b></div>
                                        </div>
                                    </div>
                                    <div
                                        class="row-cell cell-wyd-lista-5 my-auto p-4 w-30 table-cell align-middle line-height-normal text-center">
                                        <div class="flex flex-col justify-center h-full">
                                            <a href="" class="btn btn-success">Kup bilet</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <p class="text-center">Brak wydarzeń na ten dzień.</p>
                    @endforelse
                </ul>
            </div>
        </div>
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

                // function filterEvents(selectElement) {
                //     const categoryId = selectElement.value;
                //
                //     if (categoryId) {
                //         // Wywołaj żądanie AJAX do kontrolera EventController w akcji filter, przekazując categoryId.
                //         $.ajax({
                //             url: '/events/filter', // Zastąp ścieżką do odpowiedniego endpointa kontrolera.
                //             type: 'GET',
                //             data: {categoryId: categoryId},
                //             success: function (response) {
                //                 // Tutaj zaktualizuj listę wydarzeń na stronie na podstawie odpowiedzi z kontrolera.
                //             },
                //             error: function (error) {
                //                 // Obsłuż ewentualny błąd związany z żądaniem AJAX.
                //             }
                //         });
                //     }
                //
                //
                // }
            });
        </script>

        <script src="node_modules/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>

@endsection
