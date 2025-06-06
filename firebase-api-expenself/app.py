from flask import Flask, request, jsonify
import firebase_admin
from firebase_admin import credentials, firestore
import os
import json

app = Flask(__name__)

# Carrega a chave do Firebase da variável de ambiente
firebase_key_data = os.getenv("FIREBASE_KEY")

# Converte o JSON da string da variável de ambiente
cred = credentials.Certificate(json.loads(firebase_key_data))
firebase_admin.initialize_app(cred)
db = firestore.client()

@app.route("/enviar", methods=["POST"])
def enviar():
    data = request.json
    nome = data.get("nome")
    valor = data.get("valor")
    usuario = data.get("usuario", "desconhecido")

    if not nome or not valor:
        return jsonify({"error": "Nome e valor são obrigatórios"}), 400

    doc_ref = db.collection("despesas").document()
    doc_ref.set({
        "nome": nome,
        "valor": valor,
        "usuario": usuario
    })

    return jsonify({"mensagem": "Despesa enviada com sucesso!"})

if __name__ == "__main__":
    import os
port = int(os.environ.get("PORT", 5000))
app.run(host="0.0.0.0", port=port)

