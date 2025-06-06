from flask import Flask, request, jsonify
import firebase_admin
from firebase_admin import credentials, firestore
import os

# Inicialização do app Flask
app = Flask(__name__)

# Inicializa o Firebase apenas uma vez
if not firebase_admin._apps:
    cred = credentials.Certificate({
        # Substitua os valores abaixo pela sua GOOGLE_CREDENTIALS (Render)
        "type": os.environ['GOOGLE_CREDENTIALS_TYPE'],
        "project_id": os.environ['GOOGLE_CREDENTIALS_PROJECT_ID'],
        "private_key_id": os.environ['GOOGLE_CREDENTIALS_PRIVATE_KEY_ID'],
        "private_key": os.environ['GOOGLE_CREDENTIALS_PRIVATE_KEY'].replace('\\n', '\n'),
        "client_email": os.environ['GOOGLE_CREDENTIALS_CLIENT_EMAIL'],
        "client_id": os.environ['GOOGLE_CREDENTIALS_CLIENT_ID'],
        "auth_uri": "https://accounts.google.com/o/oauth2/auth",
        "token_uri": "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url": os.environ['GOOGLE_CREDENTIALS_CLIENT_CERT_URL']
    })
    firebase_admin.initialize_app(cred)

db = firestore.client()

@app.route('/listar', methods=['GET'])
def listar_despesas():
    try:
        despesas_ref = db.collection('despesas')
        docs = despesas_ref.stream()

        lista_despesas = []
        for doc in docs:
            despesa = doc.to_dict()
            despesa['id'] = doc.id
            lista_despesas.append(despesa)

        return jsonify(lista_despesas), 200
    except Exception as e:
        return jsonify({'erro': str(e)}), 500
