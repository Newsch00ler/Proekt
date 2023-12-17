@extends('experts/experts_layout')

@section('experts_main_content')
    <div class="container" style="flex-direction: column;">
        <h1 style="margin-bottom: 2%;">Проверка работы</h1>
        <h2 style="margin-bottom: 2%;"><a href="#" style="color: #000000">Сетевые игровые технологии как средство повышения эффективности учебного процесса</a></h2>
        <h2 style="margin-bottom: 2%;">Процент оригинальности работы ...%</h2>
        <div class="grid-container" style="margin-bottom: 2%;">
            <div class="grid-item"><h2>Актуальность</h2></div>
            <div class="grid-item">
                <select style="min-width: 250px">
                    <option disabled selected>Не оценено</option>
                    <option style>Актуально</option>
                    <option>Не актуально</option>
                </select>
            </div>
            <div class="grid-item"><h2>Полнота</h2></div>
            <div class="grid-item">
                <select style="min-width: 250px">
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
            <div class="grid-item"><h2>Глубина</h2></div>
            <div class="grid-item">
                <select style="min-width: 250px">
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
            <div class="grid-item"><h2>Вопросы для самопроверки<br>и ссылки на литературу</h2></div>
            <div class="grid-item">
                <select style="min-width: 250px">
                    <option disabled selected>Не оценено</option>
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                </select>
            </div>
            <div class="grid-item"><h2>Качество графического<br>материала и полезность</h2></div>
            <div class="grid-item">
                <select style="min-width: 250px">
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
        </div>
        <button type="submit">Подтвердить</button>
    </div>
@endsection
