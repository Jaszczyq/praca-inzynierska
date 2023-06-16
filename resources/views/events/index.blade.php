@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-end mb-3">

            <div class="col-auto">

                <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>

            </div>

        </div>

        <div class="row flex-wrap">

            @foreach ($events as $event)

                <div class="col-md-6 mb-4">

                    <div class="card h-100">

                        <img src="{{ $event->image }}" alt="Event Image" class="card-img-top">

                        <div class="card-body">

                            <h5 class="card-title">{{ $event['title'] }}</h5>

                            <p class="card-text">{{ $event['description'] }}</p>

                            <p class="card-text"><small class="text-muted">{{ $event['date'] }} {{ $event['time'] ?? '' }}</small></p>
                            <div class="d-flex justify-content-between">

                                <a href="{{ route('events.show', ['event' => $event['id']]) }}" class="btn btn-info mr-2">Szczegóły</a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endsection
