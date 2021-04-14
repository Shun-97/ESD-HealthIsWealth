from flask import Flask, request, jsonify
from flask_cors import CORS

import os
import sys
import requests
import json
import AMQP_setup
import pika

app = Flask(__name__)
CORS(app)

exercise_url = 'http://getexercise:5320/api/exercise'
# exercise_url = 'http://localhost:8000/api/v1/exercise'
telegram_url = 'https://g2t6-healthiswell.herokuapp.com/1717486923:AAH56XlVFTeHy-N459udrbX43bqfehL28GQ/setCalender'
@app.route("/api/SetCalendar", methods=["POST"])
def setCalendar():
    if request.is_json:
        try:
            # Send to exercise microservice
            form_data = request.get_json()
            # print(form_data)
            headers = {
                'Content-Type': "application/json",
                "Accept": "application/json",
            }

            exercise_result = requests.post(
                exercise_url, json=form_data, headers=headers).json()
            # print(exercise_result)
            message = json.dumps(
            {"message": "Data send to exercise microservice and obtained a result!"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="calendar.activity",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
            # Send to telegram
            headers = {
                'Content-Type': "application/json",
                "Accept": "application/json",
            }
            body = {
                'starttime': form_data['starttime'],
                'exercise_type': exercise_result['data']['exercise_type'],
                'description': exercise_result['data']['Description'],
                'duration': exercise_result['data']['exercise_time'],
                'username': form_data['username'],
                'telegramId': form_data['telegramid']
            }
            message = json.dumps(
            {"message": "Telegram bot has received the JSON Information"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="calendar.activity",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
            # print(body)
            telegram_result = requests.post(
                telegram_url, json=body, headers=headers)
            return exercise_result

        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            # print(ex_str)
            message = json.dumps(
                {"message": "--- internal error:" + ex_str + "---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="calendar.error",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
            return jsonify({
                "code": 500,
                "message": "recipe.py internal error: " + ex_str
            }), 500

    # if reached here, not a JSON request.
    else:
        message = json.dumps(
            {"message": "--- NOT JSON Object!:" + ex_str + "---"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="calendar.error",
                                                 body=message, properties=pika.BasicProperties(delivery_mode=2))
        return jsonify({
            "code": 400,
            "message": "Invalid JSON input: " + str(request.get_data())
        }), 400


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for searching a recipe...")
    app.run(host="0.0.0.0", port=5300, debug=True)
