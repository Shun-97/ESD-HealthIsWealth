from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os, sys
from os import environ

import requests

import json

app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

calories_url = "https://api.calorieninjas.com/v1/nutrition?query="
api_key = "REtXb+Q4bQ2JMKCYXL7+3g==urfa511CyFMRg6g0"

#Call external api to get food calories
@app.route("/api/calories", methods=["POST"])
@cross_origin()
def calories():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        query = jsondata['query']
    
        response = requests.get(calories_url + query, headers={'X-Api-Key': api_key})
        response = response.json()

        # if response.status_code == requests.code.ok:
        #     return_json = response.text
            
        # else:
        #     print("error") # error
            
    return response

#Create meal plan
@app.route("/api/calories/create", methods=["POST"])
@cross_origin()
def calories_create():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        description = jsondata['description']
        username = jsondata['username']
        total_calories = jsondata['total_calories']
        print(jsondata)

        query = "mutation MyMutation {insert_Meal(objects: {Description: \""+description+"\", Total_Calories: "+ str(total_calories)+", Username: \""+username+"\"}) {returning {Description Id Total_Calories Username}}}"
        url = "https://esd-healthiswell-69.hasura.app/v1/graphql"

        headers = {
            "content-type": "application/json",
            "x-hasura-admin-secret": "Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk"
        }
        response = requests.post(url, headers=headers, json={'query': query})
        response = response.json()
        print(response)

            
    return response

#Get all the meal plans created by user
@app.route("/api/meal", methods=["POST"])
def get_meal_by_username():
    if request.method == "POST":
        jsondata = request.get_json(force=True)
        username = jsondata["username"]

        query = "query MyQuery {Meal(where: {Username: {_eq: \""+username+"\"}}) {Description Id Total_Calories Username}}"
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

#Delete Meal plan
@app.route("/api/meal/<string:id>", methods=["DELETE"])
def delete_meal(id):
    if request.method == "DELETE":
        query = "mutation MyMutation {delete_Meal(where: {Id: {_eq: "+id+"}}) {returning {Description Id Total_Calories Username}}}"
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