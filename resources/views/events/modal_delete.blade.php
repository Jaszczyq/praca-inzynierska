<div id="modal_delete" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true" style="display:none">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
        <input type="hidden" id="id_event_delete" value="" />
        <span id="eventNameDelete"></span>
        <div
            class="inline-block p-5 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="eventDeleteForm">
                @csrf
                <input type="hidden" name="id_event" id="id_event" value="">
                <p class="text-center">{{ __('events.confirm_delete') }} <span id="event_title_delete"></span>?</p>
                <div class="mt-3 sm:mt-4 flex flex-row justify-center">
        <span class="rounded-md shadow-sm sm:ml-3 w-auto">
            <button type="submit"
                    class="inline-flex justify-center px-4 py-2 text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out">
                {{ __('events.confirm') }}
            </button>
        </span>
                    <span class="rounded-md shadow-sm sm:ml-3 w-auto">
            <button type="button" onclick="closeModalDelete()"
                    class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                {{ __('events.cancel') }}
            </button>
        </span>
                </div>
            </form>
        </div>
    </div>
</div>
