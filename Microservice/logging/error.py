import json
import os
import requests

import AMQP_setup

monitorBindingKey = '*.error'

def receiveError():
    AMQP_setup.check_setup()

    queue_name = 'Error'

    # set up a consumer and start to wait for coming messages
    AMQP_setup.channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    AMQP_setup.channel.start_consuming() # an implicit loop waiting to receive messages; 
    #it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, methos, properties, body):
    print("\nReceived an error by " + __file__)
    processError(body)
    saveToDatabase(body)
    print() # print a new line feed
    

def processError(errorMsg):
    print("Printing the error message: ")
    try:
        error = json.loads(errorMsg)
        print("--JSON:", error)
    except Exception as e:
        print("--NOT JSON:", e)
        print("--DATA:", errorMsg)
    print()

#find a way to grab username from frontend.... gg
def saveToDatabase(errorMsg):
    errorMsg = json.loads(errorMsg)
    query = 'mutation MyMutation {insert_Logging(objects: {Type: "error", Description: "'+errorMsg["message"]+'"}){affected_rows}}'
    url = 'https://esd-healthiswell-69.hasura.app/v1/graphql'
    myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
            'content-type': 'application/json'}
    r = requests.post(url, headers=myobj, json={'query': query})

if __name__ == "__main__":
    print("\nThis is " + os.path.basename(__file__), end='')
    print(": monitoring routing key '{}' in exchange '{}' ... ".format(monitorBindingKey, AMQP_setup.exchangename))
    receiveError()