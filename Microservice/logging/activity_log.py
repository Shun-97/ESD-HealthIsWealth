import json
import os
import requests

import AMQP_setup

monitorBindingKey='#.activity'

def receiveLog():
    AMQP_setup.check_setup()

    queue_name = 'Activity_Log'

    AMQP_setup.channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    AMQP_setup.channel.start_consuming()

def callback(channel, method, properties, body):
    print("\nReceived a log by " + __file__)
    processLog(json.loads(body))
    saveToDatabase(body)
    print()

def processLog(log):
    print("Recording a log:")
    print(log)

def saveToDatabase(successMsg):
    successMsg = json.loads(successMsg)
    query = 'mutation MyMutation {insert_Logging(objects: {Type: "activity", Description: "'+successMsg["message"]+'"}){affected_rows}}'
    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
            'content-type': 'application/json'}
    r = requests.post(url, headers=myobj, json={'query': query})

if __name__ == "__main__":
    print("\nThis is " + os.path.basename(__file__), end='')
    print(": monitoring routing key '{}' in exchange '{}' ...".format(monitorBindingKey, AMQP_setup.exchangename))
    receiveLog()
