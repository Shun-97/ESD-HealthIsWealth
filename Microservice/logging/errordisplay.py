from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta
from flask_cors import CORS
import os
import sys
from os import environ
import requests

import AMQP_setup
import pika
import json

app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

# Database connection
dbURL = "postgresql://bguqlttywcdyul:dcb0d826221e6019e36aee4cad4ac193e2bfa2a727748b5445187f3c852554a7@ec2-3-233-43-103.compute-1.amazonaws.com:5432/dcploeccegb868"
app.config['SQLALCHEMY_DATABASE_URI'] = dbURL
app.config['SQLALCHEMY_COMMIT_ON_TEARDOWN'] = True
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True
db = SQLAlchemy(app)


@app.route('/api/errordisplay', methods=['POST'])
def getusererror():

    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
             'content-type': 'application/json'}
    query = f"""query MyQuery {{
        Logging(where: {{Type: {{_eq: "error"}}}} ) {{
            Description
            Type
            id
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


@app.route('/api/activitydisplay', methods=['POST'])
def getuseractivity():

    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
             'content-type': 'application/json'}
    query = f"""query MyQuery {{
  Logging(where: {{Type: {{_eq: "activity"}}}} ) {{
    Description
    Type
    id
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

@app.route('/api/alluserlog', methods=['POST'])
def getalluserlog():
    if request.is_json:
        # Get existing data
        data = request.get_json()
        theusername = data["username"]
        print(theusername)
        url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
        myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
                'content-type': 'application/json'}
        query = f"""query MyQuery {{
            userLog(where: {{username: {{_eq: "{theusername}"}}}}) {{
                datetime
                logType
                userLog
                username
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

