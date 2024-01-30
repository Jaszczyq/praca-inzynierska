@php use App\Models\Event; @endphp
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="w-full max-w-xl mx-auto bg-white rounded p-5 flex flex-col items-center">
            <div class="text-center mb-5">
                <div class="text-2xl font-semibold">{{ __('booking.payment_status') }}</div>
                <div class="text-xl">{{ $payment->transaction_id }}</div>
            </div>

            @php
                $statuses = [
                    1 => ['name' => 'Oczekująca', 'color' => 'bg-yellow-500'],
                    2 => ['name' => 'Anulowana', 'color' => 'bg-gray-500'],
                    3 => ['name' => 'Zakończona', 'color' => 'bg-green-500'],
                    4 => ['name' => 'Nieopłacona', 'color' => 'bg-red-500'],
                    5 => ['name' => 'Zwrócona', 'color' => 'bg-blue-500'],
                    6 => ['name' => 'Odrzucona', 'color' => 'bg-red-500'],
                    7 => ['name' => 'Nowa', 'color' => 'bg-purple-500']
                ];
        @endphp

        <div class="text-center">
            <span class="font-semibold">{{ __('booking.payment_status_description') }}</span>
            <div class="mt-2">
                <span class="inline-block rounded-full text-white px-3 py-1 text-sm font-semibold {{ $statuses[$payment->status]['color'] }}">
                    {{ $statuses[$payment->status]['name'] }}
                </span>
            </div>
        </div>
    </div>
</div>
@if ($payment->status === 3)
    @php
        $event_id = json_decode($payment->details)[0]->event_id;
    @endphp
    <script>
        var timer = setTimeout(function() {
            window.location='{{ route('confirmation_purchase', ['id' => $event_id]) }}}'
        }, 5000);
    </script>
@endif
@endsection
