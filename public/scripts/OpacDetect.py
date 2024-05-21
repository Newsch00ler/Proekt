import os
import sys
import stat
from selenium import webdriver
from selenium.webdriver.chrome.service import Service as ChromeService
from selenium.webdriver.common.by import By
from chromedriver_py import binary_path
import time

# Переопределение стандартной кодировки на 'utf-8'
sys.stdout.reconfigure(encoding='utf-8')
sys.stderr.reconfigure(encoding='utf-8')

svc = ChromeService(executable_path=binary_path)
driver = webdriver.Chrome(service=svc)

try:
    # Открываем веб-страницу
    driver.get('http://opac.istu.edu/Opac/')

    # Находим элемент формы и кнопки
    form_field = driver.find_element("xpath", "//input[@name='valueBox2']")
    submit_button = driver.find_element("xpath", "//input[@name='searchButton']")

    # Заполняем поле формы
    form_field.send_keys(sys.argv[1])

    # Нажимаем на кнопку через JavaScript
    driver.execute_script("arguments[0].click();", submit_button)

    # Добавляем задержку, если необходимо дождаться загрузки страницы после отправки формы
    time.sleep(5)

    get_source = driver.page_source

    # Text you want to search
    search_text = sys.argv[1]

    result_box = driver.find_element(By.ID, "resultBox")
    search_elements = result_box.find_elements(By.TAG_NAME, 'p')
    found = any(search_text in element.text for element in search_elements)

    # Выводим результат
    print(found)
finally:
    # Закрываем браузер
    driver.quit()
