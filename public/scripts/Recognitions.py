import cv2
import pytesseract
import tensorflow as tf
from ultralyticsplus import YOLO, render_result
import os
import sys
import stat

os.chmod(sys.argv[1], stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

# Загрузка модели YOLO
model = YOLO('foduucom/table-detection-and-extraction')

# Настройка параметров модели
model.overrides['conf'] = 0.25
model.overrides['iou'] = 0.45
model.overrides['agnostic_nms'] = False
model.overrides['max_det'] = 1000

# Установка пути к изображению
image_path = sys.argv[1]

# Выполнение инференса
results = model.predict(image_path)

# Сбор всех распознанных текстов в одну строку
all_text = ""

# Проверка, что результаты содержат ожидаемые данные
if results[0].boxes is not None and len(results[0].boxes) > 0:
    # Получение тензора с координатами ограничивающих прямоугольников
    boxes_tensor = results[0].boxes.data
    # Извлечение координат ограничивающего прямоугольника для каждого объекта
    for i, box in enumerate(boxes_tensor):
        if len(box) >= 4:
            x, y, w, h = box[:4]
            # Извлечение области таблицы из изображения
            table_image = cv2.imread(image_path)[int(y):int(y+h), int(x):int(x+w)]
            # Распознавание текста на извлеченной области таблицы
            text = pytesseract.image_to_string(table_image, lang='rus')
            # Добавление распознанного текста в общую строку
            all_text += f"{text}\n"
        else:
            print(f"Объект {i+1} не содержит достаточно значений для распаковки")
else:
    print("Ошибка: результаты не содержат ограничивающих прямоугольников")

current_dir = os.path.dirname(os.path.abspath(__file__))
# Переход в нужную директорию + название файла
save_path = os.path.join(current_dir, 'resultRec.txt')

with open(save_path, 'w', encoding='utf-8') as file:
    file.write('\n'.join(map(str, all_text)) + '\n')
# Вывод всей собранной строки с распознанным текстом
# print(all_text)


