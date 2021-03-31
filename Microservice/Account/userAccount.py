from flask import Flask, request, render_template, redirect, url_for, session, jsonify
from flask_sqlalchemy import SQLAlchemy
import graphene
from graphene_sqlalchemy import SQLAlchemyObjectType, SQLAlchemyConnectionField
from flask_graphql import GraphQLView
from datetime import timedelta
from flask_cors import CORS
import os, sys
from app import Query, Mutation

#port 5200
app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

# Database connection
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://qepnpscgacacmr:d338fb6ef24db3eed89c7a4200ac74e8cb5c1ffd22bf8e26194eb684c6b8e33d@ec2-52-21-252-142.compute-1.amazonaws.com:5432/ddo160cbfi69qt'
app.config['SQLALCHEMY_COMMIT_ON_TEARDOWN'] = True
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = True
db = SQLAlchemy(app)

@app.route('/api/userAccount', methods=['POST'])
def getUserAccountByUsername():
    if request.is_json:
        # Get existing data
        data = request.get_json()
        username = data["username"]
        print(username)

        schema = graphene.Schema(query=Query, mutation=Mutation)
        query_string = '{userAccountByUsername(username:"' + \
            username+'"){Username Weight Height BMI}}'
        result = schema.execute(query_string)

        height = result.data["userAccountByUsername"][0]["Height"]
        weight = result.data["userAccountByUsername"][0]["Weight"]
        bmi = result.data["userAccountByUsername"][0]["BMI"]
        result_return = { 
            "username": username,
            "height": height,
            "weight": weight,
            "bmi": bmi
        }
        print(result_return)
        return jsonify({
                "code": 201,
                "data": result_return
            }), 201   

    else:
        return jsonify({
                "code": 500,
                "message": "internal error: Not Json format"
            }), 500   

@app.route('/api/userAccount/update', methods=['POST'])
def updateUserAccount():
    if request.is_json:
        data = request.get_json()
        username = data["username"]
        height = data["height"]
        weight = data["weight"]
        bmi = data["bmi"]

        schema = graphene.Schema(query=Query, mutation=Mutation)
        update_query = 'mutation{updateUseraccount(Username:"'+username+'",BMI:'+str(bmi) + \
            ',Height:'+str(height)+',Weight:'+str(weight) + \
            '){userAccount{Username BMI Height Weight}}}'
        update = schema.execute(update_query)
        print(update)
        #If the update is successful
        if update.data:
            #redirect to /profile to re-grab database info
            return jsonify({
                "code": 201,
                "data": update.data
            }), 201 

    else:
        return jsonify({
                "code": 500,
                "message": "internal error: Not JSON format"
            }), 500   

if __name__ == '__main__':
    print("This is flask " + os.path.basename(__file__) + " for userAccount...")
    app.run(port=5200, debug=True)