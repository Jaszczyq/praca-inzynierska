@extends('layouts.app')

@section('content')

    <div class="container mx-auto p-8">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full p-5">
                    <div class="text-center">
                        <p>{{ __('refunds.sent') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
