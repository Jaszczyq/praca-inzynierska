@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-5">
        <h1 class="text-2xl font-semibold mb-5">Status płatności transakcji {{ $payment->transaction_id }}</h1>
        <div class="max-w-xl mx-auto">
            @php
                $statuses = [
                    1 => ['name' => 'Oczekująca', 'color' => 'yellow'],
                    2 => ['name' => 'Anulowana', 'color' => 'gray'],
                    3 => ['name' => 'Zakończona', 'color' => 'green'],
                    4 => ['name' => 'Nieopłacona', 'color' => 'red'],
                    5 => ['name' => 'Zwrócona', 'color' => 'blue'],
                    6 => ['name' => 'Odrzucona', 'color' => 'red'],
                    7 => ['name' => 'Nowa', 'color' => 'purple']
                ];
            @endphp

            <span class="font-semibold">Status płatności</span>
            <div class="flex space-x-2">
                <span class="inline-block ml-2 rounded-full text-white px-3 py-1 text-sm font-semibold"
                      style="background-color: {{ $statuses[$payment->status]['color'] }}">
                    {{ $statuses[$payment->status]['name'] }}
                </span>
            </div>
        </div>
    </div>
@endsection
