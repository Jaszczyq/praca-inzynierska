<style>
    .grid-row {
        display: flex;
    }

    .grid-seat {
        width: 40px;
        padding-top: 40px;
        position: relative;
        border: 1px solid #ddd;
    }

    .grid-seat.active:hover {
        cursor: pointer;
        background: #ddd;
    }

</style>

<div id="sectionDialog" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display:none">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle max-w-4xl sm:w-full">
            <!-- Nagłówek modala -->
            <div class="bg-gray-100 px-4 py-3 sm:px-6">
                <span class="text-gray-700 text-lg leading-6 font-medium">{{ __('creator.managing_sections') }}</span>
                <span class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeSectionModal()">
                        <span class="sr-only">{{ __('creator.close') }}</span>
                        &times;
                    </button>
                </span>
            </div>
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3" onclick="addSectionToModal()">{{ __('creator.add_section') }}</button>
                    <div id="sectionList" class="mt-4">
                        <!-- Lista sekcji -->
                    </div>
                    <div id="sectionGrid" class="mt-4 mx-auto w-fit">
                        <!-- Siatka sekcji -->
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="generatePreview()" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('creator.generate_preview') }}
                </button>
                <button onclick="closeSectionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                    {{ __('creator.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeSectionModal() {
        document.getElementById('sectionDialog').style.display = 'none';
    }

    var selectedSection = null;

    var sectionsData = [];

    function generateRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function addSectionToModal() {
        const sectionList = document.getElementById('sectionList');

        const sectionRow = document.createElement('div');
        sectionRow.className = 'flex items-center mb-2 bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer';
        sectionRow.style.backgroundColor = generateRandomColor();
        sectionRow.onclick = () => {
            if (selectedSection && selectedSection !== sectionRow) {
                selectedSection.classList.remove('bg-gray-300')
            }
            selectedSection = sectionRow
            sectionRow.classList.add('bg-gray-300')
            calculateActiveGridFields();
        };

        const nameInput = document.createElement('input');
        nameInput.className = 'shadow appearance-none border rounded py-2 px-3 text-gray-700 mr-2';
        nameInput.placeholder = 'Nazwa sekcji';

        const seatsInput = document.createElement('input');
        seatsInput.type = 'number';
        seatsInput.className = 'shadow appearance-none border rounded py-2 px-3 text-gray-700 mr-2';
        seatsInput.placeholder = 'Ilość siedzeń';
        seatsInput.name = 'section_seats';
        seatsInput.oninput = () => {
            var dimensions = calculateGridDimensions();
            generateGrid(dimensions[1], dimensions[0]);
        }

        const rowsInput = document.createElement('input');
        rowsInput.type = 'number';
        rowsInput.className = 'shadow appearance-none border rounded py-2 px-3 text-gray-700 mr-2';
        rowsInput.placeholder = 'Ilość rzędów';
        rowsInput.name = 'section_rows';
        rowsInput.oninput = () => {
            var dimensions = calculateGridDimensions();
            generateGrid(dimensions[1], dimensions[0]);
        }

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Usuń';
        deleteButton.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
        deleteButton.onclick = () => sectionList.removeChild(sectionRow);

        sectionRow.appendChild(nameInput);
        sectionRow.appendChild(seatsInput);
        sectionRow.appendChild(rowsInput);
        sectionRow.appendChild(deleteButton);

        sectionList.appendChild(sectionRow);
    }

    function calculateGridDimensions() {
        const seatsInputs = document.getElementsByName('section_seats');
        const rowsInputs = document.getElementsByName('section_rows');

        //console.log(seatsInputs, rowsInputs);

        if (seatsInputs.length === 0) {
            return;
        }

        var totalSeats = 0;
        var totalRows = 0;

        for (var i = 0; i < seatsInputs.length; i++) {
            totalSeats += parseInt(seatsInputs[i].value);
            totalRows += parseInt(rowsInputs[i].value);
        }

        return [totalSeats, totalRows];
    }

    function generateGrid(maxRows, maxSeats) {
        const gridContainer = document.getElementById('sectionGrid');
        gridContainer.innerHTML = '';

        for (let row = 0; row < maxRows; row++) {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'grid-row';

            for (let seat = 0; seat < maxSeats; seat++) {
                const seatDiv = document.createElement('div');
                seatDiv.className = 'grid-seat';
                seatDiv.dataset.x = row;
                seatDiv.dataset.y = seat;

                rowDiv.appendChild(seatDiv);
            }

            gridContainer.appendChild(rowDiv);
        }
    }

    function colorGridFields(x, y, width, height, color) {
        const gridContainer = document.getElementById('sectionGrid');

        var colorize = true;
        var firstColorizedSeat = false;

        gridContainer.querySelectorAll('.grid-seat').forEach(seat => {
            if(seat.style.backgroundColor == color) {
                if(!firstColorizedSeat) {
                    firstColorizedSeat = seat;
                    if(colorize) {
                        if(seat.dataset.x == x && seat.dataset.y == y) {
                            colorize = false;
                        }
                    }
                }
                seat.style.backgroundColor = null;
            }
        });

        if(colorize) {
            for (let i = x; i < x + width; i++) {
                for (let j = y; j < y + height; j++) {
                    const seatDiv = gridContainer.children[i].children[j];

                    if(seatDiv.style.backgroundColor == color) {
                        seatDiv.style.backgroundColor = null;
                    }
                    else {
                        seatDiv.style.backgroundColor = color;
                    }
                }
            }
        }
    }

    function isAreaFree(x, y, width, height, gridContainer, currentSectionColor = null) {
        // for (let i = x; i < x + width; i++) {
        //     for (let j = y; j < y + height; j++) {
        //         if (i >= gridContainer.children.length || j >= gridContainer.children[i].children.length) {
        //             return false;
        //         }
        //         const seatDiv = gridContainer.children[i].children[j];
        //         if (seatDiv.style.backgroundColor && seatDiv.style.backgroundColor !== 'transparent' && seatDiv.style.backgroundColor !== currentSectionColor) {
        //             return false;
        //         }
        //     }
        // }
        return true;
    }

    function calculateActiveGridFields() {
        var selectedSectionRows = selectedSection.querySelector('[name=section_rows]').value;
        var selectedSectionSeats = selectedSection.querySelector('[name=section_seats]').value;

        const allSeats = document.getElementById('sectionGrid').querySelectorAll('.grid-seat');

        allSeats.forEach(seat => {
            seat.classList.remove('active', 'selected');
            seat.onclick = null;
        });

        var dimensions = calculateGridDimensions();
        var rows = dimensions[1];
        var seats = dimensions[0];

        var sectionColor = selectedSection.style.backgroundColor;

        for (let i = 0; i < rows; i++) {
            for (let j = 0; j < seats; j++) {
                if (i <= selectedSectionRows && j <= selectedSectionSeats) {
                    if(isAreaFree(i, j, parseInt(selectedSectionRows), parseInt(selectedSectionSeats), document.getElementById('sectionGrid'), sectionColor)) {
                        allSeats[i * seats + j].classList.add('active');
                        allSeats[i * seats + j].onclick = () => {
                            colorGridFields(i, j, parseInt(selectedSectionRows), parseInt(selectedSectionSeats), sectionColor);
                        }
                    }
                }
            }
        }
    }
</script>
