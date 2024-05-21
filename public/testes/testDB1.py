import psycopg2

# подключение к базе данных
db_params = {
    'dbname': 'MethodSovet',
    'user': 'postgres',
    'password': 'root',
    'host': '127.0.0.1',
    'port': '5432'
}

# функция для выполнения SQL-запроса
def execute_query(query, params=None):
    conn = None
    try:
        conn = psycopg2.connect(**db_params)
        cur = conn.cursor()
        cur.execute(query, params)
        conn.commit()
        cur.close()
    except (Exception, psycopg2.DatabaseError) as error:
        print(error)
    finally:
        if conn is not None:
            conn.close()

# функция для выполнения SQL-запроса и получения результата
def fetch_query(query, params=None):
    conn = None
    result = None
    try:
        conn = psycopg2.connect(**db_params)
        cur = conn.cursor()
        cur.execute(query, params)
        result = cur.fetchone()
        cur.close()
    except (Exception, psycopg2.DatabaseError) as error:
        print(error)
    finally:
        if conn is not None:
            conn.close()
    return result

# функция тестирования операций CRUD
def test_crud_operations():
    try:
        # Create
        execute_query("INSERT INTO subject_areas (name_subject_area) VALUES (%s)", ('TestNameSubjectArea',))
        print("Create: Запись создана в таблице subject_areas")

        # Read
        result = fetch_query("SELECT name_subject_area FROM subject_areas WHERE id_subject_area = (SELECT MAX(id_subject_area) FROM subject_areas)")
        if result and result[0] == 'TestNameSubjectArea':
            print("Read: Запись найдена в таблице subject_areas")
        else:
            print("Read: Запись не найдена в таблице subject_areas")

        # Update
        execute_query("UPDATE subject_areas SET name_subject_area = %s WHERE id_subject_area = (SELECT MAX(id_subject_area) FROM subject_areas)", ('TestNameSubjectArea1',))
        print("Update: Запись обновлена в таблице subject_areas")

        # Delete
        execute_query("DELETE FROM subject_areas WHERE id_subject_area = (SELECT MAX(id_subject_area) FROM subject_areas)")
        print("Delete: Запись удалена из таблицы subject_areas")

    except (Exception, psycopg2.DatabaseError) as e:
        print(f"Произошла ошибка: {e}")

# выполнение функция тестирования операций CRUD
test_crud_operations()
