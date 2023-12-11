<div id="modal_details" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true" style="display:none">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
        <div
            class="inline-block p-5 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{__('events.details')}}
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
                    <label class="block text-sm font-bold text-gray-700">
                         <span style="display: inline-block; margin-right: 10px;">
        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
            <path
                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
        </svg>
    </span>
                        <p id="event_city" class="mt-1 text-sm text-gray-600"></p>
</label>

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
