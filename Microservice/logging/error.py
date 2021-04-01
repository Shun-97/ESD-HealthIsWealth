import json
import os

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
    

def processError(errorMsg):
    print()