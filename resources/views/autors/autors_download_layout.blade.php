@extends('autors/autors_layout')

@section('autors_main_content')
    {{-- <form id="myForm" action="{{ url($url) }}" method="{{ $method }}" enctype="multipart/form-data" style=""> --}}
    {{-- <form action="{{ url('/myWorks') }}" method="post" enctype="multipart/form-data" style=""> --}}
    <form id="myForm" method="post" action="{{ url('/upload-process') }}" enctype="multipart/form-data" style="">
        @csrf
        <div class="container" style="flex-direction: column;">
            <h1>Загрузка работы</h1>
            <div class="container">

            </div>
            <input class="input" style="width: 100%; margin-top: 30px;" type="text" placeholder="Наименование"
                autocomplete="off" name="nameWork">
            <select style="margin-top: 3%; padding-right: 84px" id="typeWork" name="typeWork">
                <option disabled selected>Выбрать вид работы</option>
                <option>Учебник с грифом</option>
                <option>Учебное пособие с грифом</option>
                <option>Учебное пособие</option>
                <option>Сборник задач</option>
                <option>Практикум / лабораторный практикум</option>
                <option>Творческая работа</option>
            </select>
            <select style="width: auto; margin-top: 3%; padding-right: 84px" name="subjectAreaWork">
                <option disabled selected>Выбрать предметную область</option>
                @foreach ($subjectAreas as $subjectArea)
                    <option>{{ $subjectArea->name_subject_area }}</option>
                @endforeach
            </select>
            <div class="container" style="margin-top: 3%" id="filesContainer1">
                <input type="file" accept=".pdf" id="upload1" name="uploadedFile1" hidden />
                <label name="upload" for="upload1" style="margin-right: 42px;">
                    Учебный материал<br><br>
                    <span style="font-size: 16px;" id="labelForUpload1">
                        Загрузите файл .pdf
                    </span>
                </label>

                <input type="file" accept=".jpg, .png" id="upload2" name="uploadedFile2" hidden />
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
                name="linkWork" />
            <button style="margin-top: 3%" type="submit">Загрузить</button>
            {{-- action="upload.php" method="post"  --}}
        </div>
    </form>
@endsection







{{-- @extends('autors/autors_layout')

@section('autors_main_content') --}}
{{-- <form id="myForm" action="{{ url($url) }}" method="{{ $method }}" enctype="multipart/form-data" style=""> --}}
{{-- <form action="{{ url('/myWorks') }}" method="post" enctype="multipart/form-data" style=""> --}}
{{-- <form id="myForm" method="post" action="{{ url('/uploadProcess') }}" enctype="multipart/form-data" style="">
        @csrf
        <div class="container" style="flex-direction: column;">
            <h1>Загрузка работы</h1>
            <input class="input" style="width: 100%; margin-top: 30px;" type="text" placeholder="Наименование"
                autocomplete="off" name="nameWork">
            <select style="margin-top: 3%; padding-right: 84px" id="typeWork" name="typeWork">
                <option disabled selected>Выбрать вид работы</option>
                <option>Учебник с грифом</option>
                <option>Учебное пособие с грифом</option>
                <option>Учебное пособие</option>
                <option>Сборник задач</option>
                <option>Практикум / лабораторный практикум</option>
                <option>Творческая работа</option>
            </select>
            <select style="width: auto; margin-top: 3%; padding-right: 84px" name="subjectAreaWork">
                <option disabled selected>Выбрать предметную область</option>
                @foreach ($subjectAreas as $subjectArea)
                    <option>{{ $subjectArea->name_subject_area }}</option>
                @endforeach
            </select>
            <div class="container" style="margin-top: 3%" id="filesContainer1">
                <input type="file" accept=".pdf" id="upload1" name="uploadedFile1" hidden />
                <label name="upload" for="upload1" style="margin-right: 42px;">
                    Учебный материал<br><br>
                    <span style="font-size: 16px;" id="labelForUpload1">
                        Загрузите файл .pdf
                    </span>
                </label>

                <input type="file" accept=".jpg, .png" id="upload2" name="uploadedFile2" hidden />
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
                name="linkWork" />
            <button style="margin-top: 3%" type="submit">Загрузить</button> --}}
{{-- action="upload.php" method="post"  --}}
{{-- </div>
    </form>
@endsection --}}
