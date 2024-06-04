@extends('main_layout')

@section('main_content')
    <form id="myForm" method="post" action="{{ url('/upload-process') }}" enctype="multipart/form-data">
        @csrf
        <div style="display: flex; justify-content: center; align-items: center; text-align: center;">
            <div class="container" style="flex-direction: column; display: inline-block; ">
                <h1 style="margin-top: 4.5%;">Загрузка работы</h1>
                <div class="row-container" style="margin-top: 4.5%; display: flex; justify-content: center;">
                    <textarea class="input" style="min-width: 445px; margin-right: 42px; text-align: center;" type="text"
                        placeholder="Наименование" autocomplete="off" name="nameWork" autocomplete="off"></textarea>

                    <div class="column-conteiner" style="display: flex; flex-direction: column;">
                        <select id="typeWork" name="typeWork" placeholder="Выбрать вид работы">
                            <option disabled selected>Выбрать вид работы</option>
                            <option>Учебник с грифом</option>
                            <option>Учебное пособие с грифом</option>
                            <option>Учебное пособие</option>
                            <option>Сборник задач</option>
                            <option>Практикум / лабораторный практикум</option>
                            <option disabled>Творческая работа</option>
                        </select>
                        <select id="subjectAreaWork" name="subjectAreaWork[]" data-placeholder="Выбрать предметную область"
                            multiple>
                            <option disabled>Выбрать предметную область</option>
                            @foreach ($subjectAreas as $subjectArea)
                                <option>{{ $subjectArea->name_subject_area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="container" style="margin-top: 4.5%; justify-items: center;" id="filesContainer1">
                    <label name="upload" for="upload1" style="margin-right: 42px;">
                        <span style="font-size: 20px;">Учебный материал</span>
                        <br><br>
                        <span style="font-size: 16px; font-weight: 400;" id="labelForUpload1">
                            Загрузите файл .pdf
                        </span>
                        <input type="file" accept=".pdf" id="upload1" name="uploadedFile1" hidden />
                    </label>

                    <label name="upload" for="upload2">
                        <span style="font-size: 20px;">Выписка из протокола</span>
                        <br><br>
                        <span style="font-size: 16px; font-weight: 400;" id="labelForUpload2">
                            Загрузите файл .jpg
                        </span>
                        <input type="file" accept=".jpg" id="upload2" name="uploadedFile2" hidden />
                    </label>
                </div>

                <div class="container" style="margin-top: 4.5%; display: none;" id="filesContainer2">
                    <label name="upload" for="upload3" style="margin-right: 42px;">
                        <span style="font-size: 20px;">Творческая работа</span>
                        <br><br>
                        <span style="font-size: 16px; font-weight: 400;" id="labelForUpload3">
                            Загрузите файл .jpg, .png
                        </span>
                        <input type="file" accept=".jpg, .png" id="upload3" name="uploadedFile3" hidden />
                    </label>


                    <label name="upload" for="upload4">
                        <span style="font-size: 20px;">Справка об участии на выставках</span>
                        <br><br>
                        <span style="font-size: 16px; font-weight: 400;" id="labelForUpload4">
                            Загрузите файл .jpg, .png
                        </span>
                        <input type="file" accept=".jpg, .png" id="upload4" name="uploadedFile4" hidden />
                    </label>
                </div>

                <button style="display: block; margin: 4.5% auto 1.5% auto;" type="submit" id="download"
                    <?php if ($isDisabled) {
                        echo 'disabled';
                    } ?>>Загрузить</button>

                <label style="display: block; color: #ff0000; font-size: 18px; <?php if (!$isVisible) {
                    echo 'display: none;';
                } ?>">
                    Загрузка работ будет доступна после {{ $date }}
                </label>
            </div>
        </div>
    </form>
@endsection
