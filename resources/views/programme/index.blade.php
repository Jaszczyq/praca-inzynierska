@extends('layouts.app')

@section('content')
    <div class="container">
        @can('isOrganizer')
            <div class="mb-3 text-end">
                <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>
            </div>
        @endcan

        <div class="card">
            <div class="card-header flex justify-center">
                <div class="btn-group">
                    <a href="{{ route('events.index', ['date' => $selectedDate->copy()->subDays(min(7, now()->subDay()->diffInDays($selectedDate)))->format('Y-m-d')]) }}"
                       class="btn btn-secondary">
                        &lt;
                    </a>
                    @foreach ($dates as $date)
                        <a href="{{ route('events.index', ['date' => $date->format('Y-m-d')]) }}"
                           class="btn btn-secondary">
                            {{ $date->format('d.m') }}
                        </a>
                    @endforeach
                    <a href="{{ route('events.index', ['date' => $selectedDate->copy()->addDays(7)->format('Y-m-d')]) }}"
                       class="btn btn-secondary">
                        &gt;
                    </a>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="search" placeholder="Wyszukaj">

                <ul class="list-group">
                    @forelse ($events as $event)
                        <div class="web-div gray" style="position: relative; overflow: visible;">
                            <div class="wyd-szukaj-table">
                                <div class="table-row d-flex align-items-start">

                                    <div class="row-cell cell-wyd-lista-1 me-3 text-center p-2 my-auto"
                                         style="width: 170px;">
                                        <div class="flex flex-col justify-center h-full">
                                            <div class="no-warp linia-1">
                                                <b>{{ $event->date->format('j F Y') }}</b>
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
                                    <div class="row-cell cell-wyd-lista-2 me-3 " style="width: 310px;">
                                        <a href="{{ route('event.details', ['id' => $event->id]) }}"
                                           title="{{ $event->title }}">
                                            <img src="{{ $event->image }}" alt="{{ $event->title }}"
                                                 class="mx-auto my-auto" width="110px" height="74px"/>
                                        </a>
                                    </div>
                                    <div class="row-cell cell-wyd-lista-3 me-3 my-auto" style="width: 310px;">
                                        <div class="flex flex-col justify-center h-full">
                                            <div><b>{{ $event->title }}</b></div>
                                            <div>{{ $event->description }}</div>
                                        </div>
                                    </div>
                                    <div class="row-cell cell-wyd-lista-4 me-3 my-auto" style="width: 210px;">
                                        <div class="flex flex-col justify-center h-full">
                                            <div><b>{{ $event->place }}</b></div>
                                        </div>
                                    </div>
                                    <div class="row-cell cell-wyd-lista-5 my-auto">
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
    </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#search").on("keyup", function () {
                    var searchQuery = $(this).val();

                    $.ajax({
                        url: "/events/search/" + searchQuery,
                        method: "GET",
                        success: function (response) {
                            $("#search-results").html(response);
                        }
                    });
                });
            });
        </script>
@endsection
