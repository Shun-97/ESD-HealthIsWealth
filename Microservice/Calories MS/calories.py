from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os, sys
from os import environ

import requests

import json

app = Flask(__name__)
CORS(app)

calories_url = "https://api.calorieninjas.com/v1/nutrition?query="
api_key = "REtXb+Q4bQ2JMKCYXL7+3g==urfa511CyFMRg6g0"

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


if __name__ == "__main__":
    print("")
app.run(host="0.0.0.0", port=6100, debug=True)