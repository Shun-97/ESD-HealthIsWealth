from flask import Flask, request, jsonify
from flask_cors import CORS

import os, sys
from os import environ

import requests

import json

app = Flask(__name__)
CORS(app)

image_url= "http://localhost:5000/api/ana/"
recipe_url = "http://0.0.0.0:5100/recipe"

#Send a image link with attribute "link" in JSON format to this URL --> e.g. {"link": link_url}
@app.route("/api/recipe_image", methods=["POST"])
def recipe_image():
    if request.is_json:
        try:
            image_link = request.get_json()
            print(image_link) #I will need to grab this data from front end, might need to change this
            header = {'Content-Type': 'application/json'}
            data = {'link': image_link["link"]}
            food_result = requests.post(image_url,headers=header, json=data)
            print('recipe_result:', str(food_result.json()))
            food = food_result.json()["result"][0]['name'] + " " +food_result.json()["result"][1]['name']
            print(food)
            food_query = { "food": food }
            print(food_query)
            #recipe_result prints the SEARCH results after using recipe_url
            recipe_result = requests.post(recipe_url,headers=header, json=food_query)
            
            print(recipe_result.json()["data"]["hits"][0]["recipe"]["label"])

            return jsonify({
                "code": 201,
                "data": recipe_result.json()["data"]["hits"][0]["recipe"]["url"],
                "food": food,
                "strjsonobj": json.dumps(food_result.json())
            }), 201


        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
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
    print("This is flask " + os.path.basename(__file__) + " for searching a recipe_image...")
    app.run(host="0.0.0.0", port=5200, debug=True)