@extends('autors/autors_layout')

@section('autors_main_content')
    <form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data" style="">
        @csrf
        <div class="container" style="flex-direction: column;">
            <h1>Загрузка работы</h1>
            <input class="input" style="width: 100%; margin-top: 30px;" type="text" placeholder="Наименование"
                autocomplete="off" name="workName">
            <select style="margin-top: 3%;" id="workType" name="typeWork">
                <option disabled selected>Выбрать вид работы</option>
                <option>Учебник с грифом</option>
                <option>Учебное пособие с грифом</option>
                <option>Учебное пособие</option>
                <option>Сборник задач</option>
                <option>Практикум / лабораторный практикум</option>
                <option>Творческая работа</option>
            </select>
            <select style="min-width: 50%; margin-top: 3%" name="subAreaWork">
                <option disabled selected>Выбрать предметную область</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
            </select>
            <div class="container" style="margin-top: 3%" id="filesContainer1">
                <input type="file" accept=".pdf" id="upload1" name="uploadedFile1" hidden />
                <label name="upload" for="upload1" style="margin-right: 42px;">
                    Учебный материал<br><br>
                    <span style="font-size: 16px;" id="labelForUpload1">
                        Загрузите файл .pdf
                    </span>
                </label>

                <input type="file" accept=".jpg, .jpeg, .png" id="upload2" name="uploadedFile2" hidden />
                <label name="upload" for="upload2">
                    Выписка из протокола<br><br>
                    <span style="font-size: 16px;" id="labelForUpload2">
                        Загрузите файл .jpg, .png
                    </span>
                </label>
            </div>
            <div class="container" style="margin-top: 3%; display: none" id="filesContainer2">
                <input type="file" accept=".jpg, .png" id="upload3" name="uploadedFile3" hidden />
                <label name="upload" for="upload3" style="margin-right: 42px;">
                    Творческая работа<br><br>
                    <span style="font-size: 16px;" id="labelForUpload3">
                        Загрузите файл .jpg, .png
                    </span>
                </label>

                <input type="file" accept=".jpg, .png" id="upload4" name="uploadedFile4" hidden />
                <label name="upload" for="upload4">
                    Справка об участии на выставках<br><br>
                    <span style="font-size: 16px;" id="labelForUpload4">
                        Загрузите файл .jpg, .png
                    </span>
                </label>
            </div>
            <input class="input" style="width: 100%; margin-top: 30px;" type="text"
                placeholder="Ссылка на работу из электронной библиотеки" autocomplete="off" id="linkWork"
                name="workLink" />
            <button action="upload.php" method="post" style="margin-top: 3%" type="submit">Загрузить</button>
        </div>
    </form>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
@endsection
