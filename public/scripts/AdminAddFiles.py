import requests
from datetime import datetime
import json
import os
from pdfminer.high_level import extract_text
import tempfile
import traceback

def is_valid_pdf(file_path):
    try:
        with open(file_path, 'rb') as f:
            header = f.read(4)
        return header == b'%PDF'
    except Exception as e:
        return False

# Формируем базовый URL
url = "https://library.istu.edu/Jsoner.php?op=search_format2&db=ISTU&expr=W=$*TEK=http$*G="

# Получаем текущий год
current_year = datetime.now().year

# Добавляем текущий год к URL
formatted_url = url + str(current_year) + "&format1=@brief2&format2=@getdoc"

# Отправляем GET запрос
response = requests.get(formatted_url)

current_dir = os.path.dirname(os.path.abspath(__file__))
new_file = os.path.join(current_dir, 'new_output.json')
first_file =os.path.join(current_dir, 'first_half.json')

# Проверяем статус ответа
if response.status_code == 200:
    # Сохраняем полученный JSON в файл
    with open(new_file, 'w') as file: # путь к новому json файлу
        file.write(response.text)
    # Читаем существующий JSON файл
    try:
        with open(first_file, 'r') as file: # путь к существубщему json файлу
            existing_data = json.load(file)
    except FileNotFoundError:
        existing_data = []

    # Сериализуем данные в строки перед сравнением
    new_data_str = [json.dumps(item) for item in json.loads(response.text)]
    existing_data_str = [json.dumps(item) for item in existing_data]

    # Сравниваем новые и существующие данные
    differences = set(new_data_str) - set(existing_data_str)

    # Создаем список для новых данных
    new_items = []
    for difference in differences:
        # Десериализуем строку обратно в словарь
        new_item = json.loads(difference)
        # Добавляем новый элемент в список
        new_items.append(new_item)

    # Обновляем существующий файл, добавляя только новые данные
    existing_data.extend(new_items)
    with open(first_file, 'w') as file: # путь к существубщему json файлу
        json.dump(existing_data, file, indent=4)

    # Создаем временный файл с использованием mkstemp
    fd, tmp_file_name = tempfile.mkstemp(suffix=".json")
    os.close(fd)
    # Запись списка new_items в файл в формате JSON
    with open(tmp_file_name, 'w') as tmp_file:
        json.dump(new_items, tmp_file, indent=4)

    # Теперь переходим к работе с обновленными данными
    # Чтение обновленных данных из JSON файла
    with open(tmp_file_name, 'r') as f:
        data = json.load(f)

    # Фильтрация данных и определение пути к папке для сохранения текстовых файлов
    public_dir = os.path.abspath(os.path.join(current_dir, '..'))
    folder_path_txt = os.path.join(public_dir, 'loadTxtFiles')
    folder_path_pdf = os.path.join(public_dir, 'loadPdfFiles')
    filtered_data = [item for item in data if '.pdf' in item['url']]
    # Для каждого URL в JSON файле
    for item in filtered_data:
        try:
            # Получение URL из JSON файла
            url = item['url']

            # Генерация случайного имени для PDF файла
            pdf_file_path = os.path.join(folder_path_pdf, url.split("/")[-1])
            pdf_txt_path = os.path.join(folder_path_txt, url.split("/")[-1])

            if url.split("/")[-1].startswith('er-'):
                # Загрузка файла
                response = requests.get(url)
                if response.status_code == 200:
                    with open(pdf_file_path, 'wb') as f:
                        f.write(response.content)

                    if is_valid_pdf(pdf_file_path):
                        with open(pdf_txt_path, 'wb') as f:
                            f.write(response.content)

                        # Конвертация PDF в TXT с использованием pdfminer
                        text = extract_text(pdf_txt_path)

                        # Создание имени для текстового файла на основе имени PDF файла
                        txt_filename = pdf_txt_path.replace('.pdf', '.txt')

                        # Сохранение текста в файл
                        with open(txt_filename, 'w', encoding='utf-8') as f:
                            f.write(text)
                        os.remove(pdf_txt_path)
                    else:
                        os.remove(pdf_file_path)
        except Exception as e:
            continue

    os.remove(tmp_file_name)
else:
    print(f"Ошибка при загрузке данных: {response.status_code}")
