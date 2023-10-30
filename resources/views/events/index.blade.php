@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-end mb-3">
            <div class="col-auto">
                <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>
            </div>
        </div>

        @foreach ($events as $event)
            <div class="row mb-4">
                <div class="col-md-3">
                    <p>{{ $event['date'] }}</p>
                    <p>{{ $event['time'] ?? '' }}</p>
                </div>
                <div class="col-md-3">
                    <img src="{{ $event->image }}" alt="Event Image" class="img-fluid">
                </div>
                <div class="col-md-3">
                    <h5>{{ $event['title'] }}</h5>
                    <p>{{ $event['description'] }}</p>
                </div>
                <div class="col-md-2">
                    <p>Miejsce: {{ $event['location'] }}</p>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('events.show', ['event' => $event['id']]) }}" class="btn btn-info">Szczegóły</a>
                </div>
            </div>
        @endforeach
    </div>


@endsection
