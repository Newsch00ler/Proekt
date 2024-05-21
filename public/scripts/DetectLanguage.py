import os
import sys
import stat
from langdetect import detect
from langid.langid import LanguageIdentifier, model

os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

def detect_language():
    with open(sys.argv[1], 'r', encoding='utf-8') as file:
        text = file.read()

        # Определение языка с помощью langdetect
        detected_lang = detect(text)

        # Дополнительная проверка на русский язык с помощью langid
        identifier = LanguageIdentifier.from_modelstring(model, norm_probs=True)
        lang, confidence = identifier.classify(text)

        if lang == 'ru':
            return "Russian"
        else:
            return "Foreign"

# Вызов функции и вывод результата
result = detect_language()
print(result)
