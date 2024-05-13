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


    // отображение модального окна на странице оценки работы
    $('#myForm2').submit(function(event) {
        var isEmpty = false;

        $(this).find('#selectRelevance').each(function () {
            if ($(this).find('option:selected').text() === 'Не оценено') {
                isEmpty = true;
            }
        });
        $(this).find('#selectCompleteness').each(function () {
            if ($(this).find('option:selected').text() === 'Не оценено') {
                isEmpty = true;
            }
        });
        $(this).find('#selectDepth').each(function () {
            if ($(this).find('option:selected').text() === 'Не оценено') {
                isEmpty = true;
            }
        });
        $(this).find('#selectQuestions').each(function () {
            if ($(this).find('option:selected').text() === 'Не оценено') {
                isEmpty = true;
            }
        });
        $(this).find('#selectQuality').each(function () {
            if ($(this).find('option:selected').text() === 'Не оценено') {
                isEmpty = true;
            }
        });

        if (isEmpty) {
            $('#myModal').modal('show');
            event.preventDefault();
        }
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
            $('#myModalLogin').modal('show');
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

        var selectedValues1 = $(this).find('#subjectAreaWork').val();
        if (!selectedValues1 || selectedValues1.length === 0) {
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
            // $('input[name="linkWork"]').each(function() {
            //     if ($(this).val().trim() === "") {
            //         isEmpty = true;
            //     }
            // });
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
            return $(this).data('placeholder');
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
                case 'selectRelevance':
                    helpText.textContent = 'Актуальность (0 – 10 баллов)\n\n\n0. Отсутствие актуальности, работа не имеет\nотношения к текущим событиям или проблемам.\n\n10. Высокая актуальность, работа тесно связана\nс современными событиями, тематикой или\nпроблемами.';
                    break;
                case 'selectCompleteness':
                    helpText.textContent = 'Полнота (0 – 10 баллов)\n\n\n0. Неполные данные, работа содержит мало\nинформации или недостаточно развивает тему.\n\n10. Полнота данных, работа содержит всю\nнеобходимую информацию, тщательно\nразработана и исследована.';
                    break;
                case 'selectDepth':
                    helpText.textContent = 'Глубина (0 – 10 баллов)\n\n\n0. Поверхностный анализ, работа не\nпредоставляет глубоких исследований\nили аргументации.\n\n10. Глубокий анализ, работа представляет\nглубокие исследования, аргументацию и\nпонимание темы.';
                    break;
                case 'selectQuestions':
                    helpText.textContent = 'Наличие вопросов для самопроверки и\nссылки на литературу (0 – 10 балла)\n\n\n0. Отсутствие вопросов или ссылок,\nработа не содержит дополнительных\nисточников или инструментов для\nсамопроверки.\n\n10. Обширные вопросы и ссылки,\nработа содержит множество вопросов\nдля самопроверки и полезные ссылки\nна литературу.';
                    break;
                case 'selectQuality':
                    helpText.textContent = 'Качество иллюстраций и графического\nматериала (0 – 10 баллов)\n\n\n0. Графический материал отсутствует или\nпредставлен нечитаемым или\nнеинформативным образом.\n\n10. Представлены высококачественные и\nинформативные графические материалы,\nкоторые дополняют и обогащают текст работы.';
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
            // document.getElementById('linkWork').style.display = 'none';
            document.getElementById('filesContainer2').style.display = 'flex';
        } else {
            document.getElementById('filesContainer2').style.display = 'none';
            document.getElementById('filesContainer1').style.display = 'flex';
            // document.getElementById('linkWork').style.display = 'flex';
        }
    });
});

function filterTableByStatus() {
    var statusSelect = document.getElementById("statusSelect");
    var selectedStatus = statusSelect.options[statusSelect.selectedIndex].text;
    var table = document.getElementById("dataNameTable");
    var rows = table.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
        var statusCell = rows[i].getElementsByTagName("td")[6];
        if (statusCell) {
            var status = statusCell.textContent || statusCell.innerText;
            if (selectedStatus === "Сбросить" || status === selectedStatus) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
    statusSelect.selectedIndex = 0;
}
// Добавляем обработчик события change для селекта
document.getElementById('statusSelect').addEventListener('change', filterTableByStatus);

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

// сброс селектов на 1ое значение
function resetOptions(selectElement) {
    selectElement.selectedIndex = 0;
}
