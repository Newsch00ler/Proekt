@extends('main_layout')

@section('main_content')
    <div class="column-container" style="margin-top: 2%; display: flex; align-items: stretch;">
        <form id="myForm2" method="post" action="{{ url('/save-check-work') }}">
            @csrf
            <h1 style="margin-bottom: 10%;">Проверка работы</h1>
            <h2 style="margin-bottom: 10%; white-space: nowrap; text-decoration: underline">
                <a href="/loadPdfFiles/{{ $work->file_name }}" download style="color: #ffffff"><input type="hidden"
                        name="id_work" value="{{ $work->id_work }}">{{ $work->name_work }}</a>
            </h2>
            <div class="row-container" style="padding: 0%;">

                <div class="grid-container">
                    <div class="grid-item" style="margin-top: 0%; margin-bottom: 5%; margin-left: 0%; margin-right: 5%;">
                        <h2 style="white-space: nowrap;">
                            Процент оригинальности работы
                            @if ($work->original_percent < 61)
                                <a href="#" onclick="openModal(event, '{{ $message1 }}', '{{ $link }}')"
                                    style="color: #ff0000; text-decoration: underline">
                                    {{ $work->original_percent }} %
                                </a>
                            @else
                                <a href="#" onclick="openModal(event, '{{ $message1 }}', '{{ $link }}')"
                                    style="color: #ffffff; text-decoration: underline">
                                    {{ $work->original_percent }} %
                                </a>
                            @endif
                        </h2>
                    </div>
                    <div class="grid-item"></div>
                    <div class="grid-item">
                        <h2>Актуальность</h2>
                    </div>
                    <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                        <select style="min-width: 250px" name="selectRelevance" id="selectRelevance">
                            <option disabled selected>Не оценено</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="grid-item">
                        <h2>Полнота</h2>
                    </div>
                    <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                        <select style="min-width: 250px" name="selectCompleteness" id="selectCompleteness">
                            <option disabled selected>Не оценено</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="grid-item" id='1234'>
                        <h2>Глубина</h2>
                    </div>
                    <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                        <select style="min-width: 250px" name="selectDepth" id="selectDepth">
                            <option disabled selected>Не оценено</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="grid-item">
                        <h2>Вопросы для самопроверки<br>и ссылки на литературу</h2>
                    </div>
                    <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                        <select style="min-width: 250px" name="selectQuestions" id="selectQuestions">
                            <option disabled selected>Не оценено</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="grid-item">
                        <h2>Качество графического<br>материала и его полезность</h2>
                    </div>
                    <div class="grid-item"
                        style="white-space: nowrap;margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                        <select style="min-width: 250px" name="selectQuality" id="selectQuality">
                            <option disabled selected>Не оценено</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="grid-item"
                        style="margin: 0%; margin-top: 5%; margin-bottom: 0%; margin-left: 0%; margin-right: 5%;">
                        <button type="submit">Подтвердить</button>
                    </div>
                </div>
                <div class="help-text"></div>
            </div>
        </form>
    </div>
@endsection
