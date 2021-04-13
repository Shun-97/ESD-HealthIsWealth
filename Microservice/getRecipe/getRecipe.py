from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ
import AMQP_setup
import pika
import requests
import json

app = Flask(__name__)
CORS(app)
# app.config['CORS_HEADERS'] = 'Content-Type'
image_url = "http://getimagedetails:7100/api/ana"
# recipe_url = "http://localhost:7140/api/recipe"
img_url = "https://api.imgur.com/3/image/"
authclient = "Client-ID 0e1d07aeb2818f9"

recipe_url = "https://api.edamam.com/search"
app_id = "9427d4d5"
app_key = "3fd959075e22cb5c3be2e10ff0eb2b19"

# Send a image link with attribute "link" in JSON format to this URL --> e.g. {"link": link_url}
@app.route("/api/recipe_image", methods=["POST"])
def complex_image_search():
    try:
        # First Connection with Imgr API
        headers = {
            "Authorization": authclient,
        }

        payload = request.files
        username = request.form['username']
        # print(payload)
        # print(username)

        imgr_result = requests.post(
            img_url, files=payload, headers=headers).json()
        # print(imgr_result)
        # print(imgr_result)
        imgr_url = imgr_result['data']['link']
        message = json.dumps(
            {"message": username + "has uploaded a picture into imgur successfully and obtain a link"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="image.activity",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        # Second Connection with getImageDetails
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
        # print(image_food)

        # Insert History to database
        grapql = 'http://accountManagement:5100/api/history/add'

        body = {
            'username': username,
            'history': image_food
        }
        requests.post(
            grapql, json=body)
        # Third Connection with recipe_url
        query_url = recipe_url + "?q=" + \
            image_food + "&app_id=" + app_id + "&app_key=" + app_key

        # print(query_url)
        recipe_result = requests.get(query_url)
        message = json.dumps(
            {"message": username + "has an image link added to his upload history!"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="image.activity",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        # print(recipe_result)
        return jsonify({
            "code": 201,
            "data": recipe_result.json()
        }), 201

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


@app.route("/api/recipe", methods=["POST"])
def recipe():
    if request.is_json:
        try:
            food = request.get_json()
            print("hello")
            # I will need to grab this data from front end, might need to change this
            print(food)
            query_url = recipe_url + "?q=" + \
                food["food"] + "&app_id=" + app_id + "&app_key=" + app_key
            print(query_url)
            recipe_result = requests.get(query_url)
            print('recipe_result:', recipe_result.json())
            return jsonify({
                "code": 201,
                "data": recipe_result.json()
            }), 201

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)

            return jsonify({
                "code": 500,
                "message": "recipe.py internal error: " + ex_str
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
