@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="w-full max-w-xl mx-auto bg-white rounded p-5">
            <h1 class="text-2xl font-bold mb-6 text-center">{{ __('booking.payment_method') }} {{ $payment->method()->name }}{{ __('booking.payment_amount') }} {{ $payment->amount }} {{ __('booking.pln') }}</h1>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('payment.success', $payment->transaction_id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline flex justify-center">
                    {{ __('booking.pay') }}
                </a>
                <a href="{{ route('payment.pending', $payment->transaction_id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline flex justify-center">
                    {{ __('booking.waiting_for_payment') }}
                </a>
                <a href="{{ route('payment.fail', $payment->transaction_id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline flex justify-center">
                    {{ __('booking.payment_error') }}
                </a>
                <a href="{{ route('payment.no_payment', $payment->transaction_id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline flex justify-center">
                    {{ __('booking.no_payment') }}
                </a>
            </div>
        </div>
    </div>
@endsection
