import os
import sys
import difflib
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import string
import stat

# results = []
# result = f'Процент оригинальности с 1: 22%'
# results.append(result)
# result = f'Процент оригинальности с 2: 33%'
# results.append(result)
# result = f'Процент оригинальности с 3: 44%'
# results.append(result)

# with open('results.txt', 'w', encoding='utf-8') as result_file:
#     for result in results:
#         result_file.write(result + '\n')

# # Разрешение прав на файлы
# os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)
# os.chmod(sys.argv[2], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

# # Получение аргументов
# check_text = str(sys.argv[1]) # текст, который надо проверять
# check_directory = str(sys.argv[2]) # директория со всеми текстами

# Загрузка стоп-слов
nltk.download('punkt')
nltk.download('stopwords')

# Создание таблицы трансляции для удаления знаков препинания
table = str.maketrans('', '', string.punctuation)

# Чтение основного текста из файла
with open('C:/Users/Home/Desktop/Diplom/Proekt/public/test1/er-19101.txt', 'r', encoding='utf-8') as file:
    text1 = file.read().translate(table)

# Путь к директории с другими текстами
directory_path = "C:/Users/Home/Desktop/Diplom/Proekt/public/test2/"

# Получение списка файлов в директории
texts = os.listdir(directory_path)

# Токенизация основного текста
tokens1 = word_tokenize(text1)
# Удаление стоп-слов
tokens1 = [word for word in tokens1 if word not in stopwords.words('russian')]

results = []
differents = []

for i, text in enumerate(texts):
    with open(os.path.join(directory_path, text), 'r', encoding='utf-8') as file:
        text2 = file.read().translate(table)
        tokens2 = word_tokenize(text2)
        tokens2 = [word for word in tokens2 if word not in stopwords.words('russian')]
        # Сравнение текстов с помощью difflib
        d = difflib.Differ()
        diff = d.compare(tokens1, tokens2)

        # Вычисление процента различий
        different = len([line for line in diff if line.startswith('- ') or line.startswith('+ ')]) / len(tokens1 + tokens2) * 100
        different = round(different, 1)
        result = f'Процент оригинальности с {text}: {different}%'
        results.append(result)
        differents.append(different)

percent = sum(differents) // len(differents)

with open('C:/Users/Home/Desktop/Diplom/Proekt/public/scripts/results.txt', 'w', encoding='utf-8') as result_file:
    result_file.write('Общий процент оригинальности: ' + str(percent) + '%\n')
    # for result in results:
    #     result_file.write(result + '\n')

