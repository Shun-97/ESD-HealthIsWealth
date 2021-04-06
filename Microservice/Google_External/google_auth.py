# Need to install: https://github.com/googleapis/google-api-python-client
from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta
from google.oauth2 import id_token
from google.auth.transport import requests
from flask_cors import CORS
# import requests
import json
import os
import sys
from os import environ

app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

# GraphQl Stuff
# Database connection
dbURL = "postgresql://bguqlttywcdyul:dcb0d826221e6019e36aee4cad4ac193e2bfa2a727748b5445187f3c852554a7@ec2-3-233-43-103.compute-1.amazonaws.com:5432/dcploeccegb868"
app.config['SQLALCHEMY_DATABASE_URI'] = dbURL
app.config['SQLALCHEMY_COMMIT_ON_TEARDOWN'] = True
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True
db = SQLAlchemy(app)


class UserAccount(db.Model):
    __tablename__ = 'UserAccount'

    Username = db.Column(db.String(256), primary_key=True)
    Password = db.Column(db.String(256))
    Email = db.Column(db.String(256))
    Height = db.Column(db.Float)
    Weight = db.Column(db.Float)
    BMI = db.Column(db.Float)

    def __repr__(self):
        return '< UserAccount %r>' % self.Username

# Schema Objects


class UserAccountObject(SQLAlchemyObjectType):
    class Meta:
        model = UserAccount
        interfaces = (graphene.relay.Node, )

# Graphql Query


class Query(graphene.ObjectType):
    node = graphene.relay.Node.Field()
    all_userAccount = SQLAlchemyConnectionField(UserAccountObject)

    userAccount_by_username = graphene.List(
        UserAccountObject, username=graphene.String())

    @staticmethod
    def resolve_userAccount_by_username(parent, info, **args):
        q = args.get('username')

        userAccount_query = UserAccountObject.get_query(info)

        return userAccount_query.filter(UserAccount.Username == q).all()

# Graphql Mutation


class CreateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Password = graphene.String(required=True)
        Email = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)

    userAccount = graphene.Field(lambda: UserAccountObject)

    def mutate(self, info, Username, Password, Email, Weight=0, Height=0, BMI=0):
        userAccount = UserAccount(Username=Username, Password=Password,
                                  Email=Email, Weight=Weight, Height=Height, BMI=BMI)

        db.session.add(userAccount)
        db.session.commit()

        return CreateUserAccount(userAccount=userAccount)


class updateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)

    userAccount = graphene.Field(UserAccountObject)

    def mutate(self, info, Username, Weight, Height, BMI):
        userAccount = db.session.query(
            UserAccount).filter_by(Username=Username).first()
        userAccount.Height = Height
        userAccount.Weight = Weight
        userAccount.BMI = BMI

        db.session.commit()
        return updateUserAccount(userAccount=userAccount)


class Mutation(graphene.ObjectType):
    create_userAccount = CreateUserAccount.Field()
    update_userAccount = updateUserAccount.Field()


schema = graphene.Schema(query=Query, mutation=Mutation)


# (Receive token by HTTPS POST)
# ...
CLIENT_ID = "1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com"


def create_registration(username, email, password):
    schema = graphene.Schema(query=Query, mutation=Mutation)
    # Check if username already exist in the database

    create_userAccount = 'mutation{createUseraccount(Email:"'+email+'", Username:"' + \
        username+'",Password:"'+password + \
        '"){userAccount{Email Username Password}}}'

    # Execute
    userAccount = schema.execute(create_userAccount)
    return (True, userAccount.data["createUseraccount"])


@app.route("/api/google_signin", methods=["POST"])
def google_sign():
   #  if request.method == 'POST':
    try:
        # Specify the CLIENT_ID of the app that accesses the backend:
        token = request.get_json(force=True)['idtoken']
      #   print(token)
        idinfo = id_token.verify_oauth2_token(
            token, requests.Request(), CLIENT_ID)

        # Or, if multiple clients access the backend server:
        # idinfo = id_token.verify_oauth2_token(token, requests.Request())
        # if idinfo['aud'] not in [CLIENT_ID_1, CLIENT_ID_2, CLIENT_ID_3]:
        #     raise ValueError('Could not verify audience.')

        # If auth request is from a G Suite domain:
        # if idinfo['hd'] != GSUITE_DOMAIN_NAME:
        #     raise ValueError('Wrong hosted domain.')

        # ID token is valid. Get the user's Google Account ID from the decoded token.
        # return idinfo

        try:
            username = idinfo["name"]
            password = idinfo["sub"]

            schema = graphene.Schema(query=Query)
            query_string = '{userAccountByUsername(username:"' + \
                username + '"){Username Password Email}}'
            validate = schema.execute(query_string)

            # Check if user exist
            if not validate.data['userAccountByUsername']:
                return {
                    "code": 500,
                    "data": {
                        "message": 'Users do not exist'
                    }}

            # Check if password matches
            elif validate.data['userAccountByUsername'][0]['Password'] == password:
                return {
                    "code": 201,
                    "data": {
                        "username": username,
                        'auth': idinfo,
                        "registration": validate.data['userAccountByUsername']
                    }}

            else:
                return {
                    "code": 500,
                    "data": {
                        "message": 'Wrong Password'
                    }
                }

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "data": {
                    "message": "internal error: " + ex_str
                }}), 500

    except ValueError:
        # Invalid token
        return {
            "code": 500,
            "data": {
                "message": 'Something went wrong, Please contact us for more details'
            }}


@app.route("/api/google_signup", methods=["POST"])
def google_signup():
   #  if request.method == 'POST':
    try:
        # Specify the CLIENT_ID of the app that accesses the backend:
        token = request.get_json(force=True)['idtoken']
      #   print(token)
        idinfo = id_token.verify_oauth2_token(
            token, requests.Request(), CLIENT_ID)

        # Or, if multiple clients access the backend server:
        # idinfo = id_token.verify_oauth2_token(token, requests.Request())
        # if idinfo['aud'] not in [CLIENT_ID_1, CLIENT_ID_2, CLIENT_ID_3]:
        #     raise ValueError('Could not verify audience.')

        # If auth request is from a G Suite domain:
        # if idinfo['hd'] != GSUITE_DOMAIN_NAME:
        #     raise ValueError('Wrong hosted domain.')

        # ID token is valid. Get the user's Google Account ID from the decoded token.

        try:

            username = idinfo["name"]
            email = idinfo["email"]
            password = idinfo["sub"]
            # Create_registration will return a tuple. e.g. (True, graphql return dict data) or (False, error message)
            create = create_registration(username, email, password)
            # If True (success)
            if create[0]:
                return {
                    "code": 201,
                    "data": {
                        "username": username,
                        "registration": create[1]
                    }}

            else:
                error = "Failed to create account. Please try again"
                return {
                    "code": 500,
                    "data": error
                }
        # This part... I copied from prof's codes, I think it returns an error message if the try doesn't work
        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "internal error: " + ex_str
            }), 500

    except ValueError:
        # Invalid token
        return {
            "code": 500,
            "data": {
                "message": 'Something went wrong, Please contact us for more details'
            }}


if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) + " for google signin...")
    app.run(host="0.0.0.0", port=5110, debug=True)
