@extends('autors/autors_layout')

@section('autors_main_content')
    <div class="container" style="flex-direction: column;">
        <h1 style="margin-top: 3%">Загрузка работы</h1>
        <input class="input" style="width: 100%; margin-top: 30px;" type="text" placeholder="Наименование" name="workName">
        <select style="margin-top: 3%;">
            <option disabled selected>Выбрать вид работы</option>
            <option>Учебник с грифом</option>
            <option>Учебное пособие с грифом</option>
            <option>Учебное пособие</option>
            <option>Сборник задач</option>
            <option>Практикум / лабораторны практикум</option>
            <option>Творческая работа</option>
        </select>

        <select style="min-width: 50%; margin-top: 3%">
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
        <div class="container" style="margin-top: 3%">
                {{-- <input type="file" id="upload1" hidden/>
                <label for="upload1" style="background: #D9D9D9; border: 1px solid #000000; border-radius: 25px; color:#9B9B9B; text-align: center; width: 40%; min-height: 196px; padding: 30px; margin-right: 42px; cursor: pointer; font-size: 32px; line-height: 32px;">Учебный материал<br><br><span style="font-size: 16px;">Загрузите файл .pdf</span></label>

                <input type="file" id="upload2" hidden/>
                <label for="upload2" style="background: #D9D9D9; border: 1px solid #000000; border-radius: 25px; color:#9B9B9B; text-align: center; width: 40%; min-height: 196px; padding: 30px; margin-right: 42px; cursor: pointer; font-size: 32px; line-height: 32px;">Справка с библиотеки<br><br><span style="font-size: 16px;">Загрузите файл .jpg, .png</span></label>

                <input type="file" id="upload3" hidden/>
                <label for="upload3" style="background: #D9D9D9; border: 1px solid #000000; border-radius: 25px; color:#9B9B9B; text-align: center; width: 40%; min-height: 196px; padding: 30px; cursor: pointer; font-size: 32px; line-height: 32px;">Выписка из протокола<br><br><span style="font-size: 16px;">Загрузите файл .jpg, .png</span></label> --}}

                <input type="file" id="upload2" hidden/>
                <label for="upload2" style="background: #D9D9D9; border: 1px solid #000000; border-radius: 25px; color:#9B9B9B; text-align: center; width: 40%; min-height: 196px; padding: 30px; margin-right: 42px; cursor: pointer; font-size: 32px; line-height: 32px;">Творческая работа<br><br><span style="font-size: 16px;">Загрузите файл .jpg, .png</span></label>

                <input type="file" id="upload3" hidden/>
                <label for="upload3" style="background: #D9D9D9; border: 1px solid #000000; border-radius: 25px; color:#9B9B9B; text-align: center; width: 40%; min-height: 196px; padding: 30px; cursor: pointer; font-size: 32px; line-height: 32px;">Справка об участии на выставках<br><br><span style="font-size: 16px;">Загрузите файл .jpg, .png</span></label>
            </div>
        <button style="margin-top: 3%" type="submit">Загрузить</button>
    </div>




@endsection
