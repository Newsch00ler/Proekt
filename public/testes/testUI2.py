import requests
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

driver = webdriver.Chrome()

try:
    # авторизация секретаря
    driver.get("http://127.0.0.1:8000/login")
    username = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'login')))
    username.send_keys("VNV")
    password = driver.find_element(By.ID, 'password')
    password.send_keys("Vorontsova")
    login_button = driver.find_element(By.ID, 'login_button')
    login_button.click()

    # переход на страницу Работы (роль секретарь) после авторизации
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/show-works"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/show-works" in current_url:
        print("Переход на страницу \'Работы\' (роль секретарь) успешен после авторизации")
    else:
        print("Переход на страницу \'Работы\' (роль секретарь) НЕ успешен")

    # скачивание файла работы с наименованием 'Магматические комплексы Мамской мусковитоносной провинции'
    table = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'dataNameTable')))
    table_body = table.find_element(By.ID, 'dataTable')
    rows = table_body.find_elements(By.TAG_NAME, 'tr')
    for row in rows:
        cells = row.find_elements(By.TAG_NAME, "td")
        if any("Магматические комплексы Мамской мусковитоносной провинции" in cell.text for cell in cells):
                file_url = cells[1].find_element(By.TAG_NAME, "a").get_attribute("href")
                response = requests.get(file_url)
                assert response.status_code == 200, "Ошибка при загрузке файла"
                print("Файл работы с наименованием \'Магматические комплексы Мамской мусковитоносной провинции\' успешно скачан")

    # открытие модального окна с заимствованным маетриалом работы с наименованием 'Магматические комплексы Мамской мусковитоносной провинции'
    found = False
    for row in rows:
        cells = row.find_elements(By.TAG_NAME, "td")
        if any("Магматические комплексы Мамской мусковитоносной провинции" in cell.text for cell in cells):
            cells[3].find_element(By.TAG_NAME, "a").click()
            found = True
            break

    if not found:
        print("Строка с указанным текстом не найдена")
    else:
        modal = WebDriverWait(driver, 10).until(EC.visibility_of_element_located((By.ID, 'myModal1')))
        print("Модальное окно открыто")
        close_button = driver.find_element(By.ID, 'closeMyModal1')
        close_button.click()
        WebDriverWait(driver, 10).until(EC.invisibility_of_element(modal))
        print("Модальное окно закрыто")

    # фильтрация таблицы
    initial_row_count = len(rows)
    print(f"Количество строк таблицы до фильтрации: {initial_row_count}")
    status_select = Select(WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'statusSelect'))))
    status_select.select_by_visible_text("На проверке")
    WebDriverWait(driver, 2).until(EC.presence_of_element_located((By.ID, 'dataTable')))
    filtered_rows = table_body.find_elements(By.XPATH, './tr[@style="display: none;"]')
    filtered_row_count  = len(filtered_rows)
    print(f"Количество строк таблицы после фильтрации по значению \'На проверке\': {filtered_row_count}")
    status_select = Select(WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'statusSelect'))))
    status_select.select_by_visible_text("Сбросить")
    rows = table_body.find_elements(By.TAG_NAME, 'tr')
    update_initial_row_count = len(rows)
    print(f"Количество строк таблицы после сброса фильтрации: {update_initial_row_count}")

    # переход на страницу Эксперты (роль секретарь)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectSec')))
    select = Select(select_element)
    select.select_by_value('show-experts')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/show-experts"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/show-experts" in current_url:
        print("Переход на страницу \'Эксперты\' (роль секретарь) успешен")
    else:
        print("Переход на страницу \'Эксперты\' (роль секретарь) НЕ успешен")

    # переход на страницу Подтверждение работ (роль секретарь)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectSec')))
    select = Select(select_element)
    select.select_by_value('validation-works')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/validation-works"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/validation-works" in current_url:
        print("Переход на страницу \'Подтверждение работ\' (роль секретарь) успешен")
    else:
        print("Переход на страницу \'Подтверждение работ\' (роль секретарь) НЕ успешен")

    # переход на страницу Заседание и протокол (роль секретарь)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectSec')))
    select = Select(select_element)
    select.select_by_value('meeting')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/meeting"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/meeting" in current_url:
        print("Переход на страницу \'Заседание и протокол\' (роль секретарь) успешен")
    else:
        print("Переход на страницу \'Заседание и протокол\' (роль секретарь) НЕ успешен")

    # переход на страницу Работы для оценивания (роль эксперт)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectExp')))
    select = Select(select_element)
    select.select_by_value('e-show-works')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/e-show-works"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/e-show-works" in current_url:
        print("Переход на страницу \'Работы для оценивания\' (роль эксперт) успешен")
    else:
        print("Переход на страницу \'Работы для оценивания\' (роль эксперт) НЕ успешен")

    # переход на страницу Загрузка работы (роль автор)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectAut')))
    select = Select(select_element)
    select.select_by_value('load-my-work')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/load-my-work"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/load-my-work" in current_url:
        print("Переход на страницу \'Загрузка работы\' (роль автор) успешен")
    else:
        print("Переход на страницу \'Загрузка работы\' (роль автор) НЕ успешен")

    # переход на страницу Мои работы (роль автор)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectAut')))
    select = Select(select_element)
    select.select_by_value('my-works')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/my-works"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/my-works" in current_url:
        print("Переход на страницу \'Мои работы\' (роль автор) успешен")
    else:
        print("Переход на страницу \'Мои работы\' (роль автор) НЕ успешен")

    # переход на страницу Работы (роль секретарь)
    select_element = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, 'selectSec')))
    select = Select(select_element)
    select.select_by_value('show-works')
    WebDriverWait(driver, 10).until(EC.url_to_be("http://127.0.0.1:8000/show-works"))
    current_url = driver.current_url
    if "http://127.0.0.1:8000/show-works" in current_url:
        print("Переход на страницу \'Работы\' (роль секретарь) успешен")
    else:
        print("Переход на страницу \'Работы\' (роль секретарь) НЕ успешен")
except Exception as e:
    print(f"Произошла ошибка: {e}")
finally:
    driver.quit()
