import os
import sys
import stat
import re
from pdfminer.high_level import extract_text
from PyPDF2 import PdfReader

# Устанавливаем кодировку stdout на UTF-8
sys.stdout.reconfigure(encoding='utf-8')

os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

with open(sys.argv[1], 'rb') as file:
    reader = PdfReader(file)

    # Извлекаем текст первой страницы
    page_number = 0
    text = reader.pages[page_number].extract_text()

    # Преобразуем текст в нижний регистр для упрощения поиска
    text_lower = text.lower()

    # Находим позиции слов "издатель" или "издательство"
    start_positions = [text_lower.find("издатель"), text_lower.find("издательство")]

    # Найдем начало текста после "издатель" или "издательство", если оно присутствует
    if max(start_positions)!= -1:
        # Находим индекс начала текста после найденного слова
        start_index = max(start_positions)
        # Извлекаем текст после этого слова до конца строки или до следующего слова
        blocks = text[start_index:].split('\n')

        # Извлекаем первые три блока текста после найденного слова
        extracted_blocks = []
        for i in range(1, min(4, len(blocks))):  # Минимизируем количество блоков до трех, если их меньше
            extracted_blocks.append(blocks[i])

        # Соединяем извлеченные блоки обратно в одну строку
        extracted_text = ''.join(extracted_blocks)

        extracted_text = re.sub(r'\s+', ' ', extracted_text)

        print(extracted_text)
    else:
        print("Слово 'Издатель' или 'Издательство' не найдено на первой странице.")

