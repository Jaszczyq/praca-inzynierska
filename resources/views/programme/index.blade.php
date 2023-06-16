@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-end mb-3">

            <div class="col-auto">
                @can('isOrganizer')
                    <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>
                @endcan
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="col-auto">

{{--                        <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj wydarzenie</a>--}}

                    </div>
                    <div class="card-header">


                        <div class="btn-group">
                            <a href="{{ route('events.index', ['date' => $selectedDate->copy()->subDays(min(7, now()->subDay()->diffInDays($selectedDate)))->format('Y-m-d')]) }}" class="btn btn-secondary">
                                &lt;
                            </a>
                            @foreach ($dates as $date)
                                <a href="{{ route('events.index', ['date' => $date->format('Y-m-d')]) }}" class="btn btn-secondary">
                                    {{ $date->format('d.m') }}
                                </a>
                            @endforeach
                            <a href="{{ route('events.index', ['date' => $selectedDate->copy()->addDays(7)->format('Y-m-d')]) }}" class="btn btn-secondary">
                                &gt;
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5>{{ $selectedDate->format('d.m.Y') }}</h5>
                        <div class="row">
                            @forelse ($events as $event)
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <img src="{{ $event->image }}" alt="Event Image" style="width:150px; height: auto" class="card-img-top">
                                            <h5 class="card-title">{{ $event->title }}</h5>
                                            <p class="card-text">{{ $event->description }}</p>
                                            <p class="card-text"><small class="text-muted">{{ $event->date->format('H:i') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Brak wydarzeń na ten dzień.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectedDate = new Date("{{ $selectedDate->format('Y-m-d') }}");

            function updateUrl(date) {
                var formattedDate = formatDate(date);
                var url = "{{ route('events.index') }}" + "?date=" + formattedDate;
                window.location.href = url;
            }

            function formatDate(date) {
                var year = date.getFullYear();
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                var day = ('0' + date.getDate()).slice(-2);
                return year + '-' + month + '-' + day;
            }
        });
    </script>
@endpush
