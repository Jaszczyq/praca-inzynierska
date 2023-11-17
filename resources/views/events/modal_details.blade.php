<div id="modal_details" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true" style="display:none">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
        <div
            class="inline-block p-5 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Szczegóły Wydarzenia
                </h3>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block text-sm text-gray-700 font-bold">{{__('events.date')}}</label>
                    <p id="event_date" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.time')}}</label>
                    <p id="event_time" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.title')}}</label>
                    <p id="event_title" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.description')}}</label>
                    <p id="event_description" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.category')}}</label>
                    <p id="event_categories" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.city')}}</label>
                    <p id="event_city" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-bold text-gray-700">{{__('events.place')}}</label>
                    <p id="event_place" class="mt-1 text-sm text-gray-600"></p>
                </div>
            </div>
            <div class="bg-white justify-content-center px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button type="button" onclick="alert('Not implemented yet')"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-700 border border-transparent rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        {{ __('events.buy') }}
                    </button>
                </span>
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button type="button" onclick="closeModalDetails()"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ __('events.close') }}
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
