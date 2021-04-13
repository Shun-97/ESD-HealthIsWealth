from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ

import requests
import json
import AMQP_setup
import pika

app = Flask(__name__)
cors = CORS(app, resources={r"/api/*": {"origins": "*"}})

calories_url = "https://api.calorieninjas.com/v1/nutrition?query="
api_key = "REtXb+Q4bQ2JMKCYXL7+3g==urfa511CyFMRg6g0"

# Call external api to get food calories
@app.route("/api/calories", methods=["POST"])
@cross_origin()
def calories():
    try:
        if request.method == "POST":
            jsondata = request.get_json(force=True)
            query = jsondata['query']

            response = requests.get(
                calories_url + query, headers={'X-Api-Key': api_key})
            response = response.json()

            return response

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

# Create meal plan


if __name__ == "__main__":
    print("")
app.run(host="0.0.0.0", port=6110, debug=True)
