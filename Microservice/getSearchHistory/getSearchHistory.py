from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_cors import CORS

import os
import sys
from os import environ
import requests

app = Flask(__name__)
cors = CORS(app)


@app.route('/api/history/add', methods=['POST'])
def addHistory():
    data = request.get_json()
    username = data["username"]
    history = data["history"]
    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
             'content-type': 'application/json'}
    query = f"""mutation MyMutation {{

  insert_Search_History(objects: {{History: "{history}", Username: "{username}"}}){{
    affected_rows
  }}
}}"""
    update = requests.post(url, headers=myobj, json={
        'query': query}).json()

    return update


@app.route('/api/history/getall', methods=['POST'])
def getall():

    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
             'content-type': 'application/json'}
    query = f"""query MyQuery {{
  Search_History {{
    History
    Username
  }}
}}"""
    update = requests.post(url, headers=myobj, json={
        'query': query})
    update = update.json()
    returndata = {
        'code': 201,
        'data': update
    }
    return returndata


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=6120, debug=True)
