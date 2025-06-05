import firebase_admin
from firebase_admin import credentials, firestore

# Caminho para a chave JSON que você baixou
cred = credentials.Certificate("firebase-key.json")

# Inicializa o Firebase
firebase_admin.initialize_app(cred)

# Instancia o Firestore
db = firestore.client()

# Exemplo de dado que será enviado
nova_despesa = {
    'nome': 'Internet',
    'valor': 89.90,
    'usuario': 'admin',
}

# Adiciona na coleção "despesas"
db.collection('despesas').add(nova_despesa)

print("Despesa enviada com sucesso!")
