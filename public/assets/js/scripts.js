$(document).ready(function(){
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
});

var workTypeSelect = document.getElementById('workType');

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

