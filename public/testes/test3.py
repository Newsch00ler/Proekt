import os
import time
import requests
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service

driver = webdriver.Chrome()


try:
    driver.get("http://127.0.0.1:8000/login")

    username = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'login')))
    username.send_keys("VNV")
    password = driver.find_element(By.ID, 'password')
    password.send_keys("Vorontsova")
    login_button = driver.find_element(By.ID, 'login_button')
    login_button.click()

    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/show-works"))
    driver.get("http://127.0.0.1:8000/show-works")

    table = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'dataNameTable')))
    table_body = table.find_element(By.ID, 'dataTable')
    rows = table_body.find_elements(By.TAG_NAME, 'tr')

    found = False
    for row in rows:
        # Проверка содержимого ячеек строки
        cells = row.find_elements(By.TAG_NAME, "td")
        if any("Магматические комплексы Мамской мусковитоносной провинции" in cell.text for cell in cells):
            # Нажатие на значение в 4-м столбце этой строки
            cells[3].find_element(By.TAG_NAME, "a").click()
            found = True
            break

    if not found:
        print("Строка с указанным текстом не найдена")
    else:
        # Ожидание появления модального окна с id="myModal1"
        modal = WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.ID, 'myModal1')))
        print("Модальное окно открыто")

        # Нажатие на кнопку закрытия модального окна с id="closeMyModal1"
        close_button = driver.find_element(By.ID, 'closeMyModal1')
        close_button.click()

        # Ожидание закрытия модального окна
        WebDriverWait(driver, 10).until(EC.invisibility_of_element(modal))
        print("Модальное окно закрыто")

except Exception as e:
    print(f"Произошла ошибка: {e}")

finally:
    # Закрытие браузера
    driver.quit()
