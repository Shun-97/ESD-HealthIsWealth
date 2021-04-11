from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ

import requests

import json

app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})
telegram_url = 'https://g2t6-healthiswell.herokuapp.com/1717486923:AAH56XlVFTeHy-N459udrbX43bqfehL28GQ/foodPlan'


# Create meal plan
@app.route("/api/meal/planning", methods=["POST"])
@cross_origin()
def planning():
    try:
        if request.method == "POST":
            jsondata = request.get_json(force=True)
            description = jsondata['description']
            username = jsondata['username']
            total_calories = jsondata['total_calories']
            telegramid = jsondata['telegramid']
            # print(jsondata)
            print(username)
            print(telegramid)
            # Send to telegram
            headers = {
                'Content-Type': "application/json",
                "Accept": "application/json",
            }
            body = {
                'description': description,
                'username': username,
                'total_calories': total_calories,
                'telegramId': telegramid
            }
            telegram_result = requests.post(
                telegram_url, json=body, headers=headers)

            # Insert to Meal Table
            query = "mutation MyMutation {insert_Meal(objects: {Description: \""+description+"\", Total_Calories: " + str(
                total_calories)+", Username: \""+username+"\"}) {returning {Description Id Total_Calories Username}}}"
            url = "https://esd-healthiswell-69.hasura.app/v1/graphql"

            headers = {
                "content-type": "application/json",
                "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
            }
            response = requests.post(
                url, headers=headers, json={'query': query})
            print(response)
            returnresponse = {
                'code': 201,
                'response': response.json()}
            # print(response)
            return returnresponse

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


# Get all the meal plans created by user
@app.route("/api/meal", methods=["POST"])
def get_meal_by_username():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        username = jsondata["username"]

        query = "query MyQuery {Meal(where: {Username: {_eq: \"" + \
            username+"\"}}) {Description Id Total_Calories Username}}"
        url = "https://esd-healthiswell-69.hasura.app/v1/graphql"
        print(query)
        headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
        }
        response = requests.post(url, headers=headers, json={'query': query})
        response = response.json()
        print(response)

    return response

# Delete Meal plan
@app.route("/api/meal/<string:id>", methods=["DELETE"])
def delete_meal(id):
    if request.method == "DELETE":
        query = "mutation MyMutation {delete_Meal(where: {Id: {_eq: " + \
            id+"}}) {returning {Description Id Total_Calories Username}}}"
        url = "https://esd-healthiswell-69.hasura.app/v1/graphql"

        headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
        }
        response = requests.post(url, headers=headers, json={'query': query})
        response = response.json()
        print(response)

    return response


if __name__ == "__main__":
    print("")
app.run(host="0.0.0.0", port=6100, debug=True)
