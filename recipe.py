from flask import Flask, request, jsonify
from flask_cors import CORS

import os, sys
from os import environ

import requests

import json

app = Flask(__name__)
CORS(app)

recipe_url  = "https://api.edamam.com/search"
app_id = "9427d4d5"
app_key = "3fd959075e22cb5c3be2e10ff0eb2b19"

@app.route("/recipe", methods=["POST"])
def recipe():
    if request.is_json:
        try:
            food = request.get_json()
            print("hello")
            print(food["food"]) #I will need to grab this data from front end, might need to change this

            query_url = recipe_url + "?q=" + food["food"] + "&app_id=" + app_id + "&app_key=" + app_key
            print(query_url)
            recipe_result = requests.get(query_url)
            print('recipe_result:', recipe_result)

            return jsonify({
                "code": 201,
                "data": recipe_result.json()
                }), 201


        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + fname + ": line " + str(exc_tb.tb_lineno)
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
    print("This is flask " + os.path.basename(__file__) + " for searching a recipe...")
    app.run(host="0.0.0.0", port=5100, debug=True)