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
dbURL = "postgresql://qepnpscgacacmr:d338fb6ef24db3eed89c7a4200ac74e8cb5c1ffd22bf8e26194eb684c6b8e33d@ec2-52-21-252-142.compute-1.amazonaws.com:5432/ddo160cbfi69qt"
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
                                  Email=Email, Weight=Weight, Height=Height, BMI=BMI, Requested_Calories=Requested_Calories)

        db.session.add(userAccount)
        db.session.commit()

        return CreateUserAccount(userAccount=userAccount)


class updateUserAccount(graphene.Mutation):
    class Arguments:
        Username = graphene.String(required=True)
        Weight = graphene.Float(required=False)
        Height = graphene.Float(required=False)
        BMI = graphene.Float(required=False)
        Requested_Calories = graphene.Float(required=False)

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


@app.route('/api/login/verification', methods=['POST'])
def login():
    if request.method == 'POST':
        jsondata = request.get_json(force=True)
        # return request.form
        username = jsondata['username']
        password = jsondata['password']

        schema = graphene.Schema(query=Query)
        query_string = '{userAccountByUsername(username:"' + \
            username + '"){Username Password Email}}'
        validate = schema.execute(query_string)
        # print(validate)
        # Check if user exist
        if not validate.data['userAccountByUsername']:
            # return {"message": "user don't exist"}
            message = json.dumps({"message": username + ": user don't exist"})


            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))

            return {
                "code": 500,
                "data": {
                    "message": 'Users do not exist'
                }}

            # Check if password matches
        elif validate.data['userAccountByUsername'][0]['Password'] == password:
            message = json.dumps({"message": username + ": Successful Login"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            return {
                "code": 201,
                "data": {
                    "username": username,
                    "registration": validate.data['userAccountByUsername']
                }}

        else:
            message = json.dumps({"message": username + ": Wrong Password"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            return {
                "code": 500,
                "data": {
                    "message": 'Wrong Password'
                }}
            # return {"message": "user don't exist"}
    elif request.is_json:
        try:
            google = request.get_json()
            print("Received")
            username = google["username"]
            password = google["password"]

            schema = graphene.Schema(query=Query)
            query_string = '{userAccountByUsername(username:"' + \
                username + '"){Username Password Email}}'
            validate = schema.execute(query_string)

            # Check if user exist
            if not validate.data['userAccountByUsername']:
                message = json.dumps(
                    {"message": username + ": user don't exist"})
                AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
                return {
                    "code": 500,
                    "data": {
                        "message": 'Users do not exist'
                    }}

            # Check if password matches
            elif validate.data['userAccountByUsername'][0]['Password'] == password:
                message = json.dumps(
                    {"message": username + ": Successful Login"})
                AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.activity",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
                return {
                    "code": 201,
                    "data": {
                        "username": username,
                        "registration": validate.data['userAccountByUsername']
                    }}

            else:
                message = json.dumps(
                    {"message": username + ": Wrong Password"})
                AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
                return {
                    "code": 500,
                    "data": {
                        "message": 'Wrong Password'
                    }}

            return jsonify(google)

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)
            message = json.dumps({"message": "internal error: " + ex_str})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            return jsonify({
                "code": 500,
                "data": {
                    "message": "internal error: " + ex_str
                }}), 500


@app.route('/api/register/verification', methods=['POST'])
def register():
    if request.is_json:
        try:
            # Grab the data
            google = request.get_json()
            print("Received")
            # Map the data
            username = google["username"]
            email = google["email"]
            password = google["password"]
            if "@gmail.com" in email or "@smu.edu.sg" in email:
                # Create_registration will return a tuple. e.g. (True, graphql return dict data) or (False, error message)
                create = create_registration(username, email, password)
                # If True (success)
                if create[0]:
                    message = json.dumps(
                        {"message": username + ": Account successfully created"})
                    AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.activity",
                                                     body=message, properties=pika.BasicProperties(delivery_mode=2))
                    return {
                        "code": 201,
                        "data": {
                            "username": username,
                            "registration": create[1]
                        }}

                else:
                    error = create[1]
                    message = json.dumps({"message": username + " : " + error})
                    AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                                     body=message, properties=pika.BasicProperties(delivery_mode=2))
                    return {
                        "code": 500,
                        "data": error
                    }
            else:
                return {
                    "code": 500,
                    "data": "Please use a gmail account"
                }

        # This part... I copied from prof's codes, I think it returns an error message if the try doesn't work
        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)
            message = json.dumps({"message": "internal error: " + ex_str})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))

            return jsonify({
                "code": 500,
                "message": "internal error: " + ex_str
            }), 500

    else:
        message = json.dumps(
            {"message": username + " : Account creation failed"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        return {
            "code": 500,
            "message": "Failed to create account. Please try again"
        }


def create_registration(username, email, password):
    schema = graphene.Schema(query=Query, mutation=Mutation)
    # Check if username already exist in the database
    exist = username_exist(username)

    # Check if user exist
    if exist[0]:
        return (False, exist[1])  # error msg

    else:
        # Query
        create_userAccount = 'mutation{createUseraccount(Email:"'+email+'", Username:"' + \
            username+'",Password:"'+password + \
            '"){userAccount{Email Username Password}}}'

        # Execute
        userAccount = schema.execute(create_userAccount)
        return (True, userAccount.data["createUseraccount"])

# Checks the database if the username exsit


def username_exist(username):
    schema = graphene.Schema(query=Query, mutation=Mutation)
    # Qeury
    query_string = '{userAccountByUsername(username:"' + \
        username + '"){Username Password Email}}'
    # Execute
    validate = schema.execute(query_string)

    # If there's data in registrationByUsername, give error
    if validate.data['userAccountByUsername']:
        error = "user exist, Please login instead"
        return (True, error)
    else:
        return (False, validate.data['userAccountByUsername'])


@app.route('/api/userAccount', methods=['POST'])
def getUserAccountByUsername():
    if request.is_json:
        # Get existing data
        data = request.get_json()
        username = data["username"]
        print(username)

        url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
        myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
                 'content-type': 'application/json'}
        update_query = f"""query MyQuery {{
                        UserAccount(where: {{Username: {{_eq: "{username}"}}}}) {{
                            BMI
                            Email
                            Height
                            Password
                            Requested_Calories
                            Username
                            Weight
                        }}
                        }}"""
        update = requests.post(url, headers=myobj, json={
                               'query': update_query})
        update = update.json()

        returndata = {
            'code': 201,
            'data': update['data']["UserAccount"]
        }
        return returndata

    else:
        return jsonify({
            "code": 500,
            "message": "internal error: Not Json format"
        }), 500


@app.route('/api/userAccount/update', methods=['POST'])
def updateUserAccount1():
    if request.is_json:
        data = request.get_json()
        username = data["username"]
        height = data["height"]
        weight = data["weight"]
        bmi = data["bmi"]
        calories = data['calories']

        url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
        myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
                 'content-type': 'application/json'}
        update_query = 'mutation MyMutation {update_UserAccount(where: {Username: {_eq: "'+username+'"}}, _set: {BMI: "'+str(
            bmi)+'", Height: "'+str(height)+'", Weight: "'+str(weight)+'" , Requested_Calories: "'+str(calories)+'"}) {returning { BMI Height Username Weight Requested_Calories}}}'
        update = requests.post(url, headers=myobj, json={
                               'query': update_query})
        update = update.json()
        # print(update)
        returning = update["data"]["update_UserAccount"]["returning"]
        # If the update is successful
        if returning:
            # redirect to /profile to re-grab database info
            print("???")
            message = json.dumps(
                {"message": username + " : Account successfully updated"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            print(message)
            return jsonify({
                "code": 201,
                "data": returning
            }), 201

    else:
        message = json.dumps(
            {"message": username + " : Account update failed, not JSON format"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="account.error",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        return jsonify({
            "code": 500,
            "message": "internal error: Not JSON format"
        }), 500


app.add_url_rule(
    '/graphql',
    view_func=GraphQLView.as_view(
        'graphql',
        schema=schema,
        graphiql=True  # for having the GraphiQL interface
    )
)

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5100, debug=True)
