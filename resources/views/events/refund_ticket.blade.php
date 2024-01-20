@extends('layouts.app')

@section('content')

<div class="container mx-auto p-8">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-5">
                <div class="text-center">
                    <h1 class="text-gray-600 font-bold text-2xl mb-1">Zwrot Biletu</h1>
                    <p>Wpisz wymagane informacje, aby zwrócić bilet</p>
                </div>
                <form class="mt-4" action="{{ route('tickets.refundData') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                    <div>
                        <label class="block" for="ticketPrice">Cena biletu</label>
                        <input type="text" placeholder="Wpisz cenę biletu" name="ticketPrice" id="ticketPrice" class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>
                    <div class="mt-4">
                        <label class="block" for="email">Adres Email</label>
                        <input type="email" placeholder="Wpisz swój adres email" name="email" id="email" class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Wyślij dane</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
