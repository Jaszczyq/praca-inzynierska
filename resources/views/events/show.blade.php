@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $event->title }}</div>
                    <div class="card-body">
                        <img src="{{ $event->image }}" alt="Event Image" class="card-img-top">

                        <p>{{ $event->description }}</p>
                        <p>{{ $event->date }} {{ $event->time }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
