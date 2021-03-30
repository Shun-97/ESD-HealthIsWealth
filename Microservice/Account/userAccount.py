from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta
from flask_cors import CORS
import os, sys
from Microservice.Account.app import Query, Mutation

#port 5200
app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

@app.route('/api/userAccount/{{username}}', methods=['GET','POST'])
def getUserAccountByUsername():
    if request.get:
        pass
    elif request.post:
        pass

if __name__ == '__main__':
    app.run(port=5200, debug=True)