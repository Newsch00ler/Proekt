import os
import sys
from pdfminer.high_level import extract_text
import stat

# Разрешение прав на файлы
os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

# Получение аргументов
pdf_file = str(sys.argv[1])
txt_file = str(sys.argv[2])

# Проверка существования входного файла
# if not os.path.isfile(arg1):
#     print(f"Входной файл {arg1} не существует.")
#     sys.exit(1)

# # Проверка существования выходного файла
# if os.path.isfile(arg2):
#     print(f"Выходной файл {arg2} уже существует.")
#     sys.exit(1)

# Извлечение текста из PDF-файла
text = extract_text(pdf_file)

# Запись текста в TXT-файл
with open(txt_file, 'w', encoding='utf-8') as output_file:
        output_file.write(text)
