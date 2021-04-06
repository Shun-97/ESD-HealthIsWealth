from flask import Flask, request, jsonify
from flask_cors import CORS, cross_origin

import os
import sys
from os import environ

import requests

import json

app = Flask(__name__)
CORS(app)

url = "https://api.imgur.com/3/image/"
authclient = "Client-ID 0e1d07aeb2818f9"


@app.route("/api/imgr", methods=["POST"])
def imgr():
    # print('lol')
    # print(request.form['image'])
    try:
        headers = {
            "Authorization": authclient,
        }
        payload = request.files
        print(payload)

        r = requests.post(url, files=payload, headers=headers)

        return jsonify({
            "code": 201,
            "data": r.json()
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


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for searching a recipe...")
app.run(host="0.0.0.0", port=7130, debug=True)
