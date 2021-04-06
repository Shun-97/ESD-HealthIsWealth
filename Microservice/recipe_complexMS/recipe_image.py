from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ

import requests
import json

app = Flask(__name__)
CORS(app)
# app.config['CORS_HEADERS'] = 'Content-Type'
image_url = "http://127.0.0.1:7100/api/ana"
recipe_url = "http://127.0.0.1:7140/api/recipe"
img_url = "http://127.0.0.1:7130/api/imgr"

# Send a image link with attribute "link" in JSON format to this URL --> e.g. {"link": link_url}
@app.route("/api/recipe_image", methods=["POST"])
def complex_image_search():
    try:
        # First Connection with Imgr API
        headers = {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        }
        payload = request.files
        # print(payload)
        imgr_result = requests.post(
            img_url, files=payload, headers=headers).json()
        # print(imgr_result)
        print(imgr_result)
        imgr_url = imgr_result['data']['data']['link']

        # Second Connection with recipt.py
        headers = {
            'Content-Type': "application/json",
            "Accept": "application/json",
        }
        body = {
            "link": imgr_url
        }
        image_result = requests.post(
            image_url, json=body, headers=headers).json()
        # print(recipe_result)
        image_food = image_result['result'][0]['name']

        # Third Connection with recipe_url
        headers = {
            "Content-type": "application/json"
        }
        body = {
            "food": image_food
        }
        recipe_result = requests.post(
            recipe_url, json=body, headers=headers).json()

        return recipe_result
    except Exception as e:
        # Unexpected error in code
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        ex_str = str(e) + " at " + str(exc_type) + ": " + \
            fname + ": line " + str(exc_tb.tb_lineno)
        print(ex_str)

        return jsonify({
            "code": 500,
            "message": "recipe_image.py internal error: " + ex_str
        }), 500

        # if reached here, not a JSON request.

    return jsonify({
        "code": 400,
        "message": "Invalid JSON input: " + str(request.get_data())
    }), 400


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for searching a recipe_image...")
    app.run(host="0.0.0.0", port=7120, debug=True)
