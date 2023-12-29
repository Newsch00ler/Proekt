import os
import sys
from pdfminer.high_level import extract_text
import stat

def convert_pdf_to_txt(input_file_path, output_file_path):
  os.chmod(input_file_path, stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)
  os.chmod(output_file_path, stat.S_IRUSR | stat.S_IRGRP | stat.S_IROTH)

  # Проверка существования входного файла
  if not os.path.isfile(input_file_path):
      print(f"Входной файл {input_file_path} не существует.")
      sys.exit(1)

  # Проверка существования выходного файла
  if os.path.isfile(output_file_path):
      print(f"Выходной файл {output_file_path} уже существует.")
      sys.exit(1)

  # Извлечение текста из PDF-файла
  text = extract_text(input_file_path)

  # Запись текста в TXT-файл
  with open(output_file_path, 'w') as file:
      file.write(text)

# if name == "main":
#    input_file_path = sys.argv[1]
#    output_file_path = sys.argv[2]
#    convert_pdf_to_txt(input_file_path, output_file_path)
