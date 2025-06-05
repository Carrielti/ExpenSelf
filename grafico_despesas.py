import sys
import mysql.connector
import matplotlib.pyplot as plt

# Verifica se há argumento para destacar uma despesa
highlight = sys.argv[1] if len(sys.argv) > 1 else None

# Conexão com o banco de dados
conn = mysql.connector.connect(
    host="sql113.infinityfree.com",
    user="if0_39027470",
    password="expenself01",  # Altere se necessário
    database="if0_39027470_bd_expenself"
)
cursor = conn.cursor()

# Consulta todos os dados da tabela despesas
query = "SELECT nome, valor FROM despesas ORDER BY valor DESC"
cursor.execute(query)
resultados = cursor.fetchall()

# Fecha a conexão
conn.close()

# Se não houver resultados
if not resultados:
    print("Nenhuma despesa encontrada.")
    exit()

# Prepara os dados
nomes = [linha[0] for linha in resultados]
valores = [linha[1] for linha in resultados]

# Define cores com destaque se necessário
cores = []
for nome in nomes:
    if nome == highlight:
        cores.append("#6cdd7f")  # cor destacada (laranja)
    else:
        cores.append("lightgray")  # cor padrão

# Cria o gráfico
plt.style.use("_mpl-gallery")
plt.figure(figsize=(10, 6))
bars = plt.bar(nomes, valores, color=cores)
plt.bar_label(bars, fmt='R$ %.2f', padding=3)
plt.xlabel('Despesas')
plt.ylabel('Valor (R$)')
plt.title('Gastos Totais - ExpenSelf')
plt.xticks(rotation=45)
plt.tight_layout()
plt.savefig("/img/grafico.png")
plt.close()

print("Gráfico gerado com sucesso!")