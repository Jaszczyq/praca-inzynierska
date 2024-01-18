@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold my-4">Metoda płatności: {{ $payment->method()->name }}, kwota: {{ $payment->amount }}</h1>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('payment.success', $payment->transaction_id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Zapłać</a>
            <a href="{{ route('payment.pending', $payment->transaction_id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Oczekiwanie na wpłatę</a>
            <a href="{{ route('payment.fail', $payment->transaction_id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Błąd płatności</a>
            <a href="{{ route('payment.no_payment', $payment->transaction_id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Brak wpłaty</a>
        </div>
    </div>
@endsection
