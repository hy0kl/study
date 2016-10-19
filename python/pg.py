import psycopg2
import psycopg2.extras
import json

connect = psycopg2.connect(database="dev", user="work", password="work")
cursor  = connect.cursor(cursor_factory=psycopg2.extras.DictCursor)

sql = 'SELECT id, mobile FROM account ORDER BY id DESC '

cursor.execute(sql)
ret = cursor.fetchall()
print(ret)
print(json.dumps(ret))
print(ret[0]['id'])
