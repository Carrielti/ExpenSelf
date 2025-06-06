from flask import Flask, request, jsonify
import firebase_admin
from firebase_admin import credentials, firestore
import os
import json

app = Flask(__name__)

# Inicializa o Firebase apenas uma vez
if not firebase_admin._apps:
    firebase_config = json.loads(os.environ['FIREBASE-KEY'])
    cred = credentials.Certificate(firebase_config)
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
