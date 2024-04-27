$(document).ready(function () {
    // изменение полей для файлов
    $('input[id="upload1"]').change(function(e){
        var fileName = e.target.files[0].name;
        document.getElementById('labelForUpload1').textContent = 'Файл ' + fileName.substr(0, 13) + '... загружен';
    });
    $('input[id="upload2"]').change(function(e){
        var fileName = e.target.files[0].name;
        document.getElementById('labelForUpload2').textContent = 'Файл ' + fileName.substr(0, 13) + '... загружен';
    });
    $('input[id="upload3"]').change(function(e){
        var fileName = e.target.files[0].name;
        document.getElementById('labelForUpload3').textContent = 'Файл ' + fileName.substr(0, 13) + '... загружен';
    });
    $('input[id="upload4"]').change(function(e){
        var fileName = e.target.files[0].name;
        document.getElementById('labelForUpload4').textContent = 'Файл ' + fileName.substr(0, 13) + '... загружен';
    });

    // отображение модального окна на странице авторизации
    $('#myForm1').submit(function(event) {
        var isEmpty = false;

        $(this).find('input[name="login"]').each(function() {
            if ($(this).val().trim() === "") {
                isEmpty = true
            }
        });

        $(this).find('input[name="password"]').each(function () {
            if ($(this).val().trim() === "") {
                isEmpty = true
            }
        });

        if (isEmpty) {
            $('#myModal').modal('show');
            event.preventDefault();
        }
    });

    // отображение модального окна на странице загрузки работ
    $('#myForm').submit(function(event) {
        var isEmpty = false;

        $(this).find('textarea[name="nameWork"]').each(function() {
            if ($(this).val().trim() === "") {
                isEmpty = true
            }
        });

        $(this).find('#typeWork').each(function () {
            if ($(this).find('option:selected').is(':disabled')) {
                isEmpty = true
            }
        });

        var selectedValues = $(this).find('#subjectAreaWork').val();
        if (!selectedValues || selectedValues.length === 0) {
            isEmpty = true;
        }

        var isFilesContainer1Visible = $('#filesContainer1').is(':visible');
        var isFilesContainer2Visible = $('#filesContainer2').is(':visible');
        if (isFilesContainer1Visible) {
            $('#filesContainer1 input[type="file"]').each(function() {
                if ($(this)[0].files.length === 0) {
                    isEmpty = true;
                }
            });
            $('input[name="linkWork"]').each(function() {
                if ($(this).val().trim() === "") {
                    isEmpty = true;
                }
            });
        } else if (isFilesContainer2Visible) {
            $('#filesContainer2 input[type="file"]').each(function() {
                if ($(this)[0].files.length === 0) {
                    isEmpty = true;
                }
            });
        }

        if (isEmpty) {
            $('#myModal').modal('show');
            event.preventDefault();
        }
    });

    $('#subjectAreaWork').select2({
        minimumResultsForSearch: Infinity,
        placeholder: function () {
            $(this).data('placeholder');
        }
    });
});

// модальное окно для ссылок в таблицах
function openModal(event, message, link) {
    document.getElementById('modalMessage1').innerHTML = '<a href="' + link + '" target="_blank">' + message + '</a>';
    $('#myModal1').modal('show');
    event.preventDefault();
}

// модальное окно 2 для ссылок в таблицах
function openModal(event, message) {
    document.getElementById('modalMessage1').innerText = message;
    $('#myModal1').modal('show');
    event.preventDefault();
}

// отображение вспомогательного текста на странице оценки работы экспертом
document.addEventListener("DOMContentLoaded", function () {
    const helpText = document.querySelector('.help-text');

    document.querySelectorAll('.grid-item select').forEach(select => {
        select.addEventListener('mouseenter', () => {
            switch (select.id) {
                case 'grItemRelevance':
                    helpText.textContent = '1. Текст для актуальности \n 2. \n 3. \n 4. \n 5. \n 6. \n 7. \n 8. \n 9. \n 10. ';
                    break;
                case 'grItemCompleteness':
                    helpText.textContent = 'Текст для полноты';
                    break;
                case 'grItemDepth':
                    helpText.textContent = 'Текст для глубины';
                    break;
                case 'grItemQuestions':
                    helpText.textContent = 'Текст для вопросов';
                    break;
                case 'grItemQuality':
                    helpText.textContent = 'Текст для качества графического материала';
                    break;
            }
            helpText.style.display = 'block';
        });
        select.addEventListener('mouseleave', () => {
            helpText.style.display = 'none';
        });
    });
});

// отображение элементов на странице загрузки работ автором
document.addEventListener('DOMContentLoaded', function () {
    var workTypeSelect = document.getElementById('typeWork');

    workTypeSelect.addEventListener('change', function () {
        var selectedOption = workTypeSelect.options[workTypeSelect.selectedIndex];
        var selectedIndex = selectedOption.index;

        if (selectedIndex == 6) {
            document.getElementById('filesContainer1').style.display = 'none';
            document.getElementById('linkWork').style.display = 'none';
            document.getElementById('filesContainer2').style.display = 'flex';
        } else {
            document.getElementById('filesContainer2').style.display = 'none';
            document.getElementById('filesContainer1').style.display = 'flex';
            document.getElementById('linkWork').style.display = 'flex';
        }
    });
});

// поиск по таблице
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("dataTable");
    let rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        let shouldDisplay = false;
        let cells = rows[i].getElementsByTagName("td");

        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                let txtValue = cells[j].textContent || cells[j].innerText;
                let inputText = cells[j].querySelector("input");
                let selectText = cells[j].querySelector("select");

                if (inputText) {
                    txtValue = inputText.value.toLowerCase();
                }

                if (selectText) {
                    txtValue = selectText.value.toLowerCase();
                }

                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    shouldDisplay = true;
                    break;
                }
            }
        }

        if (shouldDisplay) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

// сортировка по таблице
function sortTable(n) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("dataNameTable");
    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

// $(document).ready(function() {
//     $('#typeWork').select2({
//         placeholder: function () {
//             $(this).data('placeholder');
//         }
//     });
// });
