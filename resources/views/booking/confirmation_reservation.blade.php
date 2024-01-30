@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="w-full max-w-xl mx-auto bg-white rounded p-5">
            <h1 style="text-align: center; font-weight: bold;">{{ __('ticket.ticket_reserved') }}</h1>
            <div class="ticket-reservation-wrapper">
                <div class="ticket-reservation">
                    <p><strong>{{ __('ticket.title') }}</strong> {{ $event->title }}</p>
                    <p><strong>{{ __('ticket.city') }}</strong> {{ $event->city }}</p>
                    <p><strong>{{ __('ticket.place') }}</strong> {{ $event->place }}</p>
                    <p><strong>{{ __('ticket.date') }}</strong> {{ $event->date->format('d.m.Y') }}</p>
                    <p><strong>{{ __('ticket.time') }}</strong> {{ (new DateTime($event->time))->format('H:i') }}</p>
                </div>
                <div class="event-image">
                    <img src="{{ $event->image }}" alt="Obraz wydarzenia">
                </div>
            </div>
        </div>
    </div>

    <style>
        .ticket-reservation-wrapper {
            display: flex;
        }

        .ticket-reservation {
            flex: 1;
            padding: 20px;
        }

        .event-image {
            width: 50%; /* Zajmuje 50% szerokości kontenera */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-image img {
            border-radius: 10px;
            object-fit: cover;
            max-width: 100%;
            max-height: 50vh; /* Maksymalna wysokość obrazu to 50% wysokości viewportu */
            aspect-ratio: 16 / 9;
        }
    </style>

@endsection
