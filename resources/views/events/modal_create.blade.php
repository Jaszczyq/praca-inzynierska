<div id="modal_create" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true" style="display:none">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
        <div
            class="inline-block p-5 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" id="lessonForm">
                @csrf
                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{ __('events.create') }}
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-group">
                        <label for="title"
                               class="block text-sm font-medium text-gray-700">{{ __('events.title') }}</label>
                        <input type="text" name="title" id="title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="description"
                               class="block text-sm font-medium text-gray-700">{{ __('events.description') }}</label>
                        <textarea name="description" id="description"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="city"
                               class="block text-sm font-medium text-gray-700">{{ __('events.city') }}</label>
                        <input type="text" name="city" id="city"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="place"
                               class="block text-sm font-medium text-gray-700">{{ __('events.place') }}</label>
                        <textarea name="place" id="place"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category"
                               class="block text-sm font-medium text-gray-700">{{ __('events.category') }}</label>
                        <select name="category" id="category"
                                class="mt-1 block bg-white w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date" class="block text-sm font-medium text-gray-700">{{ __('events.date') }}</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="form-group">
                        <label for="time" class="block text-sm font-medium text-gray-700">{{ __('events.time') }}</label>
                        <input type="time" name="time" id="time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div id="ticketTypesWithPrices">
                        @foreach($ticketTypes as $ticketType)
                            <div>
                                <label for="ticket_types[{{ $ticketType->id }}][price]">{{ $ticketType->name }}</label>
                                <input type="text" name="ticket_types[{{ $ticketType->id }}][price]" id="ticket_types[{{ $ticketType->id }}][price]" value="{{ old('ticket_types.' . $ticketType->id . '.price') }}" required>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="image"
                               class="block text-sm font-medium text-gray-700">{{ __('events.image') }}</label>
                        <input type="file" name="image" id="image"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                </div>

                <div class="bg-white justify-content-center px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="submit"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ __('events.add') }}
                        </button>
                    </span>
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="button" onclick="closeModal()"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ __('events.close') }}
                        </button>
          </span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    document.getElementById('date').setAttribute('min', new Date().toISOString().split('T')[0]);

    // Funkcja aktualizująca atrybut 'min' dla pola czasu na bieżącą godzinę, jeśli data jest dzisiejsza
    function updateTimeMinValue() {
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const currentDate = new Date().toISOString().split('T')[0];

        if (dateInput.value === currentDate) {
            const currentTime = new Date().toTimeString().split(' ')[0];
            timeInput.setAttribute('min', currentTime);
        } else {
            // Usuwanie ograniczenia czasu, jeśli wybrana jest inna data niż dzisiejsza
            timeInput.removeAttribute('min');
        }
    }

    // Nasłuchiwanie zmian w polu daty
    document.getElementById('date').addEventListener('change', updateTimeMinValue);

    document.addEventListener('DOMContentLoaded', (event) => {
        // Przykładowe ceny dla różnych typów biletów
        let ticketPrices = {
            '1': 10.00,
            '2': 20.00,
            '3': 30.00,
            '4': 40.00
        };

        // Dla każdego typu biletu w formularzu
        for (let i = 1; i <= 4; i++) {
            let ticketTypeSelect = document.getElementById('ticket_type_' + i);
            let priceInput = document.getElementById('ticket_price_' + i);

            // Nasłuchuj zmian w polu wyboru typu biletu
            ticketTypeSelect.addEventListener('change', function() {
                // Pobierz wybrany typ biletu
                let selectedTicketType = this.value;

                // Zaktualizuj pole ceny na podstawie wybranego typu biletu
                if (selectedTicketType in ticketPrices) {
                    priceInput.value = ticketPrices[selectedTicketType];
                } else {
                    priceInput.value = '';  // Wyczyść pole ceny, jeśli typ biletu nie ma przypisanej ceny
                }
            });
        }
    });
</script>
