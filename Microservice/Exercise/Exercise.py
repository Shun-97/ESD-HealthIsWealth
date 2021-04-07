from flask import Flask, request, jsonify
from flask_cors import CORS

import os
import sys
from os import environ
import random
import requests
import AMQP_setup
import pika
import json

app = Flask(__name__)
CORS(app)


@app.route("/api/exercise", methods=["POST"])
def recipe():
    if request.is_json:
        try:
            # Define all variable
            exercise_data = request.get_json()
            date = exercise_data['date']
            duration = exercise_data['duration']
            difficulty = exercise_data['difficulty']
            message = json.dumps(
                {"message": "--- Data Successfully obtained via Input Fields ---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            message = json.dumps({"message": "--- Calling GraphQL ---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
        # Calling Graphql
            query = f"""query MyQuery {{
                        ExerciseFatty_Exercises(where: {{_and: {{exercise_time: {{_eq: "{duration}"}}}}, type: {{_eq: "{difficulty}"}}}}) {{
                            Description
                            calories_burnt
                            exercise_id
                            exercise_time
                            exercise_type
                            type
                        }}
                        }}"""

            url = 'https://esd-healthiswell-69.hasura.app/v1/graphql/'
            myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
                     'content-type': 'application/json'}
            r = requests.post(url, headers=myobj, json={'query': query})
            result = r.json()['data']['ExerciseFatty_Exercises']

            # from the array chose one
            message = json.dumps(
                {"message": "--- Obtaining Exercise Challenge from GraphQL ---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            randomint = random.randrange(0, len(result))
            message = json.dumps(
                {"message": "--- Successfully sent to the user ---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.activity",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            return {
                "code": r.status_code,
                "data": result[randomint]
            }
        except Exception as e:
            # Unexpected error in code
            exc_type, exc_obj, exc_tb = sys.exc_info()
            fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
            ex_str = str(e) + " at " + str(exc_type) + ": " + \
                fname + ": line " + str(exc_tb.tb_lineno)
            print(ex_str)
            message = json.dumps(
                {"message": "--- internal error:" + ex_str + "---"})
            AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.error",
                                             body=message, properties=pika.BasicProperties(delivery_mode=2))
            return jsonify({
                "code": 500,
                "message": "recipe.py internal error: " + ex_str
            }), 500

    # if reached here, not a JSON request.
    else:
        message = json.dumps(
            {"message": "--- NOT JSON Object!:" + ex_str + "---"})
        AMQP_setup.channel.basic_publish(exchange=AMQP_setup.exchangename, routing_key="exercise.error",
                                         body=message, properties=pika.BasicProperties(delivery_mode=2))
        return jsonify({
            "code": 400,
            "message": "Invalid JSON input: " + str(request.get_data())
        }), 400


# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is flask " + os.path.basename(__file__) +
          " for searching a recipe...")
    app.run(host="0.0.0.0", port=5310, debug=True)
