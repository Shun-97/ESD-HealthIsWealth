import json
import os

import AMQP_setup

monitorBindingKey='#'

def receiveLog():
    AMQP_setup.check_setup()

    queue_name = 'Activity_Log'

    AMQP_setup.channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    AMQP_setup.channel.start_consuming()

def callback(channel, method, properties, body):
    print("\nReceived a log by " + __file__)
    processLog(json.loads(body))
    print()

def processLog(log):
    print("Recording a log:")
    print(log)

if __name__ == "__main__":
    print("\nThis is " + os.path.basename(__file__), end='')
    print(": monitoring routing key '{}' in exchange '{}' ...".format(monitorBindingKey, AMQP_setup.exchangename))
    receiveLog()
