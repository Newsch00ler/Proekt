@extends('experts/experts_layout')

@section('experts_main_content')
    <div class="column-container" style="margin-top: 2%; display: flex; align-items: stretch;">
        <h1 style="margin-bottom: 10%;">Проверка работы</h1>
        <h2 style="margin-bottom: 10%; white-space: nowrap;"><a href="#" style="color: #ffffff">Сетевые игровые
                технологии как средство
                повышения эффективности учебного процесса</a></h2>
        <div class="row-container" style="padding: 0%;">
            <div class="grid-container">
                <div class="grid-item" style="margin-top: 0%; margin-bottom: 5%; margin-left: 0%; margin-right: 5%;">
                    <h2 style="white-space: nowrap;">
                        Процент оригинальности работы <a href="#" style="color: #ffffff">...%</a></h2>
                </div>
                <div class="grid-item"></div>
                <div class="grid-item">
                    <h2>Актуальность</h2>
                </div>
                <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                    <select style="min-width: 250px" id="grItemRelevance">
                        <option disabled selected>Не оценено</option>
                        <option style="justify-items: center">1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="grid-item">
                    <h2>Полнота</h2>
                </div>
                <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                    <select style="min-width: 250px" id="grItemCompleteness">
                        <option disabled selected>Не оценено</option>
                        <option style="justify-items: center">1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="grid-item" id='1234'>
                    <h2>Глубина</h2>
                </div>
                <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                    <select style="min-width: 250px" id="grItemDepth">
                        <option disabled selected>Не оценено</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="grid-item">
                    <h2>Вопросы для самопроверки<br>и ссылки на литературу</h2>
                </div>
                <div class="grid-item" style="margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                    <select style="min-width: 250px" id="grItemQuestions">
                        <option disabled selected>Не оценено</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="grid-item">
                    <h2>Качество графического<br>материала и полезность</h2>
                </div>
                <div class="grid-item"
                    style="white-space: nowrap;margin-top: 5%; margin-bottom: 5%; margin-left: 5%; margin-right: 5%;">
                    <select style="min-width: 250px" id="grItemQuality">
                        <option disabled selected>Не оценено</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                </div>
                <div class="grid-item"
                    style="margin: 0%; margin-top: 5%; margin-bottom: 0%; margin-left: 0%; margin-right: 5%;">
                    <button type="submit">Подтвердить</button>
                </div>
            </div>
            <div class="help-text"></div>
        </div>
    </div>
@endsection
