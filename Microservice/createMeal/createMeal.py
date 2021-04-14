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
telegram_url = 'https://g2t6-healthiswell.herokuapp.com/1717486923:AAH56XlVFTeHy-N459udrbX43bqfehL28GQ/foodPlan'


# Create meal plan
@app.route("/api/meal/create", methods=["POST"])
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
            # print(username)
            # print(telegramid)
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
            message = json.dumps(
                {"message": "Data is sending to Telegram Bot"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meal.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))

            # Insert to Meal Table
            # url = "http://localhost:6130/api/meal/insert"
            url = "http://getmeals:6130/api/meal/insert"

            body = {
                'description': description,
                'username': username,
                'total_calories': total_calories,
            }

            headers = {
                'Content-Type': "application/json",
                "Accept": "application/json",
            }
            getMeals_result = requests.post(
                url, headers=headers, json=body)
            # print(response)
            message = json.dumps(
                {"message": "Meal is successfully inserted into the Meal Table in the Database!"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meal.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))

            # print(getMeals_result)
            returnresponse = {
                'code': 201,
                'response': getMeals_result.json()}
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
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="meal.error",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        return jsonify({
            "code": 500,
            "data": {
                "message": "internal error: " + ex_str
            }}), 500


if __name__ == "__main__":
    print("")
app.run(host="0.0.0.0", port=6100, debug=True)
