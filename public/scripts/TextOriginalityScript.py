import os
import nltk
import re
import sys
import stat

# Разрешение прав на файлы
# os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)
# os.chmod(sys.argv[2], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

download_text = str(sys.argv[1])
check_directory = str(sys.argv[2])

def compare_paragraphs(text1, text2):
    # Удаление переносов слов, идущих через тире
    text1 = re.sub(r'[\n-]', '', text1)
    text2 = re.sub(r'[\n-]', '', text2)

    # nltk.download('punkt')  # загрузка необходимых данных для токенизации текста

    # Токенизация текстов на абзацы
    tokenizer = nltk.data.load('tokenizers/punkt/russian.pickle')
    paragraphs1 = tokenizer.tokenize(text1)
    paragraphs2 = tokenizer.tokenize(text2)

    # Инициализация переменных для подсчета общего процента заимствований
    total_paragraphs = len(paragraphs1)
    total_percent_borrowings = 0

    # Сравнение абзацев
    for i, (para1, para2) in enumerate(zip(paragraphs1, paragraphs2)):
        words_para1 = set(para1.split())
        words_para2 = set(para2.split())

        common_words = words_para1.intersection(words_para2)
        percent_common = len(common_words) / max(len(words_para1), len(words_para2)) * 100

        # Добавление процента заимствований для текущего абзаца к общему
        total_percent_borrowings += percent_common

    # Вычисление общего процента заимствований
    overall_percent_borrowings = total_percent_borrowings / total_paragraphs
    return overall_percent_borrowings

# Загрузка текста из файла для text1
with open(download_text, 'r', encoding='utf-8') as file:
    text1 = file.read()

# Загрузка текста из всех файлов в папке для text2
folder_path = str(sys.argv[2])
all_texts = []
file_names = []  # Список для хранения названий файлов
for filename in os.listdir(folder_path):
    if filename.endswith('.txt'):
        with open(os.path.join(folder_path, filename), 'r', encoding='utf-8') as file:
            text2 = file.read()
            all_texts.append(text2)
            file_names.append(filename)  # Добавление названия файла в список

# Список для хранения пар документов и процента заимствования
borrowing_pairs = []

# Сравнение er-31155.txt с каждым другим документом
for i, text2 in enumerate(all_texts):
    if file_names[i] != os.path.basename(download_text):  # Пропускаем сам файл er-31155.txt
        percent_borrowings = compare_paragraphs(text1, text2)
        borrowing_pairs.append((file_names[i], round(percent_borrowings, 2)))

# Сортировка списка по убыванию процента заимствования
borrowing_pairs.sort(key=lambda x: x[1], reverse=True)

# Вычисление общего процента заимствования
total_borrowings = sum(pair[1] for pair in borrowing_pairs)
average_percent_borrowings = total_borrowings / len(borrowing_pairs)

output_list = [[round(average_percent_borrowings,2)]]
for pair in borrowing_pairs[:5]:
    output_list.append([pair[0], pair[1]])

current_dir = os.path.dirname(os.path.abspath(__file__))
save_path = os.path.join(current_dir, 'resultOrig.txt')

# Запись списка в файл result.txt
with open(save_path, 'w', encoding='utf-8') as file:
    for item in output_list:
        file.write('\n'.join(map(str, item)) + '\n')


