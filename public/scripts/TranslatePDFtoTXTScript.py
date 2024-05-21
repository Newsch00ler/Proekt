import os
import sys
from pdfminer.high_level import extract_text, extract_pages
import stat

# Разрешение прав на файлы
os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

# Получение аргументов
pdf_file = str(sys.argv[1])
txt_file = str(sys.argv[2])

# Извлечение текста из PDF-файла
text = extract_text(pdf_file)

# Запись текста в TXT-файл
with open(txt_file, 'w', encoding='utf-8') as output_file:
    output_file.write(text)

# Подсчет количества страниц в PDF-файле
pages_generator = extract_pages(pdf_file)
num_pages = sum(1 for _ in pages_generator)  # Используем генератор списка для подсчета страниц

# Вывод количества страниц
print(int(num_pages))
