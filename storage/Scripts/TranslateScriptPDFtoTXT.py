def convert_pdf_to_txt(input_file_path, output_file_path):
   from pdfminer.high_level import extract_text

   # Извлечение текста из PDF-файла
   text = extract_text(input_file_path)

   # Запись текста в TXT-файл
   with open(output_file_path, 'w') as file:
       file.write(text)