import mysql.connector

# Conexão
conn = mysql.connector.connect(
    host="sql113.infinityfree.com",
    user="if0_39027470",
    password="expenself01",  # Altere se necessário
    database="if0_39027470_bd_expenself"
)

cursor = conn.cursor()

# Executa consulta
cursor.execute("SELECT nome, valor, data_despesa FROM despesas")

# Mostra os dados
for linha in cursor.fetchall():
    print(linha)

cursor.close()
conn.close()
