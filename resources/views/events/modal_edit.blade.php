<div id="modal_edit" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
     aria-modal="true" style="display:none">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 opacity-75"></div>
        <div
            class="inline-block p-5 align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="eventEditForm">
                @csrf
                <div class="mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    {{ __('events.edit') }}
                </div>
                <input type="hidden" name="id_event" id="id_event" value="">
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-group">
                        <label for="titleEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.title') }}</label>
                        <input type="text" name="title" id="titleEdit" value=""
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="descriptionEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.description') }}</label>
                        <textarea name="description" id="descriptionEdit"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cityEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.city') }}</label>
                        <input type="text" name="city" id="cityEdit" value=""
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="placeEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.place') }}</label>
                        <input type="text" name="place" id="placeEdit" value=""
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="categoryEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.category') }}</label>
                        <select name="category" id="categoryEdit"
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
                        <label for="dateEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.date') }}</label>
                        <input type="date" name="date" id="dateEdit"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="timeEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.time') }}</label>
                        <input type="time" name="time" id="timeEdit"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="imageEdit"
                               class="block text-sm font-medium text-gray-700">{{ __('events.image') }}</label>
                        <input type="file" name="image" id="imageEdit"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 flex justify-center space-x-4">
                    <button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out">
                        {{ __('events.update') }}
                    </button>
                    <button type="button" onclick="closeModalEdit()"
                            class="inline-flex justify-center px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        {{ __('events.close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
