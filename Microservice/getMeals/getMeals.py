from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ

import requests
import AMQP_setup
import pika
import json

app = Flask(__name__)
CORS(app)


@app.route("/api/meal/insert", methods=["POST"])
def insert_meal_by_username():
    jsondata = request.get_json(force=True)
    # print(jsondata)
    description = jsondata['description']
    username = jsondata['username']
    total_calories = jsondata['total_calories']

    query = "mutation MyMutation {insert_Meal(objects: {Description: \""+description+"\", Total_Calories: " + str(
                total_calories)+", Username: \""+username+"\"}) {returning {Description Id Total_Calories Username}}}"
    url = "https://esd-healthiswell-69.hasura.app/v1/graphql"
      #   print(query)
    headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
    }
    response = requests.post(url, headers=headers, json={'query': query})
    response = response.json()
    # print(response)
    message = json.dumps(
            {"message": username + "obtains all meal from database successfully"})
    AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meals.activity",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
    return response

# Get all the meal plans created by user
@app.route("/api/meal/getAll", methods=["POST"])
def get_meal_by_username():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        username = jsondata["username"]

        query = "query MyQuery {Meal(where: {Username: {_eq: \"" + \
            username+"\"}}) {Description Id Total_Calories Username}}"
        url = "https://esd-healthiswell-69.hasura.app/v1/graphql"
        # print(query)
        headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
        }
        response = requests.post(url, headers=headers, json={'query': query})
        response = response.json()
        print(response)
        message = json.dumps(
            {"message": username + "obtains all meal from database successfully"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meals.activity",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
    return response

# Delete Meal plan
@app.route("/api/meal/delete", methods=["POST"])
def delete_meal():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        id = jsondata["id"]
        username = jsondata['username']
        # query = "mutation MyMutation {delete_Meal(where: {Username: {_eq: " + \
        #    username +"}, Id: {_eq: " + id + "}}) {returning {Description Id Total_Calories Username}}}"
        query = "mutation MyMutation {delete_Meal(where: {Id: {_eq: " + \
            id+"}}) {returning {Description Id Total_Calories Username}}}"
        url = "https://esd-healthiswell-69.hasura.app/v1/graphql"

        headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
        }
        response = requests.post(url, headers=headers, json={'query': query})
        response = response.json()
        # print(response)
        message = json.dumps(
            {"message": username + "has deleted a row of id : " + id})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meals.activity",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
    return response


if __name__ == "__main__":
    # print("")
    app.run(host="0.0.0.0", port=6130, debug=True)
