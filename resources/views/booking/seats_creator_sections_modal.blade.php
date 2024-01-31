<style>
    .grid-row {
        display: flex;
        height: 35px;
    }

    .grid-seat {
        width: 35px;
        padding-top: 35px;
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

    function addSectionToSeats(seats, section) {
        for (let i = 0; i < seats.length; i++) {
            seats[i].dataset.section = section.id;
        }
        generateGrid();
    }

    function addSectionToModal() {
        const sectionList = document.getElementById('sectionList');

        const sectionRow = document.createElement('div');
        sectionRow.className = 'flex items-center mb-2 bg-gray-100 p-2 rounded hover:bg-gray-200 cursor-pointer';
        sectionRow.style.backgroundColor = generateRandomColor();
        sectionRow.id = "section_" + sectionList.children.length;
        sectionRow.onclick = (e) => {
            if (e.target.tagName === 'INPUT') return;
            if (selectedSection && selectedSection !== sectionRow) {
                selectedSection.classList.remove('bg-gray-300');
            }
            selectedSection = sectionRow;
            sectionRow.classList.add('bg-gray-300');
            addSectionToSeats(selectedSeats, sectionRow);
        };

        const nameInput = document.createElement('input');
        nameInput.className = 'shadow appearance-none border rounded py-2 px-3 text-gray-700 mr-2';
        nameInput.placeholder = 'Nazwa sekcji';

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Usuń';
        deleteButton.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
        deleteButton.onclick = () => sectionList.removeChild(sectionRow);

        sectionRow.appendChild(nameInput);
        sectionRow.appendChild(deleteButton);

        sectionList.appendChild(sectionRow);
    }

    var colorCache = [];

    function drawSections() {
        const seats = document.querySelectorAll('.seat');
        /*const canvas = document.getElementById('hallCanvas');
        const ctx = canvas.getContext('2d');

        ctx.fillStyle = 'red';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        //ctx.clearRect(0, 0, canvas.width, canvas.height);*/

        seats.forEach(seat => {
            const sectionId = seat.dataset.section;
            if (sectionId) {
                try {
                    const sectionElement = document.getElementById(sectionId);
                    const rgb = sectionElement.style.backgroundColor
                        .match(/\d+/g)
                        .map(x => parseInt(x));

                    seat.style.backgroundColor = "rgba(" + rgb[0] + ", " + rgb[1] + ", " + rgb[2] + ", 0.5)";
                }
                catch (e) {

                }
                //console.log(seat);

                /*if (!colorCache[sectionElement.style.backgroundColor]) {
                    const rgb = sectionElement.style.backgroundColor
                        .match(/\d+/g)
                        .map(x => parseInt(x));

                    const color = new Color(rgb[0], rgb[1], rgb[2]);
                    const solver = new Solver(color);
                    const result = solver.solve();
                    const filter = result.filter.replace("filter: ", "").replace(";", "");
                    console.log(filter);
                    seat.style.filter = filter;
                    console.log(seat);

                    colorCache[sectionElement.style.backgroundColor] = filter;
                }

                seat.style.filter = colorCache[sectionElement.style.backgroundColor];*/

                /*const x = seat.offsetLeft;
                const y = seat.offsetTop;

                console.log(x, y);
                console.log(seat.offsetWidth, seat.offsetHeight);

                // Rysowanie obszaru sekcji
                ctx.fillStyle = color;
                ctx.globalAlpha = 0.5; // Ustaw przezroczystość
                ctx.fillRect(x, y, seat.offsetWidth, seat.offsetHeight);*/
            }
        });
    }

    function generateGrid() {
        const gridContainer = document.getElementById('sectionGrid');
        gridContainer.innerHTML = '';

        var rows = document.querySelectorAll('.row');

        maxRows = rows.length;

        for (let row = 0; row < maxRows; row++) {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'grid-row';

            var width = rows[row].offsetWidth;

            var seats = rows[row].querySelectorAll('.seat');

            for (let seat = 0; seat < seats.length; seat++) {
                const seatDiv = document.createElement('div');
                seatDiv.className = 'grid-seat';
                seatDiv.dataset.x = row;
                seatDiv.dataset.y = seat;
                seatDiv.style.position = 'absolute';
                seatDiv.style.left = (seats[seat].offsetLeft/width)*100 + '%';

                if(seats[seat].dataset.section) {
                    try {
                        seatDiv.style.backgroundColor = document.getElementById(seats[seat].dataset.section).style.backgroundColor;
                    }
                    catch (e) {

                    }
                }

                rowDiv.appendChild(seatDiv);
            }

            gridContainer.appendChild(rowDiv);
        }

        drawSections();
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
                    try {
                        const seatDiv = gridContainer.children[i].children[j];

                        if (seatDiv.style.backgroundColor == color) {
                            seatDiv.style.backgroundColor = null;
                        } else {
                            seatDiv.style.backgroundColor = color;
                        }
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
        }
    }
</script>
