from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from os import environ
from flask_cors import CORS

db = SQLAlchemy()
DB_NAME = "database"

def create_app():
    app = Flask(__name__)
    app.config['SECRET_KEY'] = 'ESD_SecretKey'

    from .views import views
    from .auth import auth

    app.register_blueprint(views, url_prefix="/")
    app.register_blueprint(auth, url_prefix="/")

    return app
