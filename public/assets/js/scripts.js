$(document).ready(function () {
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

    $('#myForm1').submit(function(event) { // проверка заполненности формы
        var isEmpty = false;

        $(this).find('input[name="login"]').each(function() {
            if ($(this).val().trim() === "") {
                isEmpty = true;
                return false;
            }
        });

        $(this).find('input[name="password"]').each(function () {
            if ($(this).val().trim() === "") {
                isEmpty = true;
                return false;
            }
        });

        if (isEmpty) {
            console.log("зашел");
            $('#myModal1').modal('show'); // отображение модального окна, если есть пустые поля или селекты
            event.preventDefault(); //предотвращение отправки формы
        }
    });

    $('#myForm').submit(function(event) { // проверка заполненности формы
        var isEmpty = false;

        $(this).find('input[name="nameWork"]').each(function() {
            if ($(this).val().trim() === "") {
                isEmpty = true;
                return false;
            }
        });

        $(this).find('select').each(function () {
            if ($(this).find('option:selected').is(':disabled')) {
                isEmpty = true;
                return false;
            }
        });

        var isFilesContainer1Visible = $('#filesContainer1').is(':visible');
        var isFilesContainer2Visible = $('#filesContainer2').is(':visible');
        if (isFilesContainer1Visible) {
            $('#filesContainer1 input[type="file"]').each(function() {
                if ($(this)[0].files.length === 0) {
                    isEmpty = true;
                    return false;
                }
            });
            $('input[name="linkWork"]').each(function() {
                if ($(this).val().trim() === "") {
                    isEmpty = true;
                    return false;
                }
            });
        } else if (isFilesContainer2Visible) {
            $('#filesContainer2 input[type="file"]').each(function() {
                if ($(this)[0].files.length === 0) {
                    isEmpty = true;
                    return false;
                }
            });
        }

        // var messageElement = document.querySelector('.modal-body');
        // var message = messageElement.textContent || messageElement.innerText;

        // if (message.startsWith("Файл с именем")) {
        //     isEmpty = true;
        //     return false;
        // }

        if (isEmpty) {
            $('#myModal').modal('show'); // отображение модального окна, если есть пустые поля или селекты
            event.preventDefault(); //предотвращение отправки формы
        }
    });
});

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
