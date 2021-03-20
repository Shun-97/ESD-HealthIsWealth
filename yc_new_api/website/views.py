from flask import Blueprint, render_template, request, jsonify
from clarifai_grpc.channel.clarifai_channel import ClarifaiChannel
from clarifai_grpc.grpc.api import resources_pb2, service_pb2, service_pb2_grpc
from clarifai_grpc.grpc.api.status import status_pb2, status_code_pb2
import json

def imgapi(link):
    channel = ClarifaiChannel.get_grpc_channel()

    stub = service_pb2_grpc.V2Stub(channel)

    # This will be used by every Clarifai endpoint call.
    metadata = (('authorization', 'Key f1b91994ff22442b97d4b07eb0089d9b'),)

    post_model_outputs_response = stub.PostModelOutputs(
        service_pb2.PostModelOutputsRequest(
            model_id="bd367be194cf45149e75f01d59f77ba7",
            # This is optional. Defaults to the latest model version.
            #   version_id="{THE_MODEL_VERSION_ID}",
            inputs=[
                resources_pb2.Input(
                    data=resources_pb2.Data(
                        image=resources_pb2.Image(
                            url=link
                        )
                    )
                )
            ]
        ),
        metadata=metadata
    )
    if post_model_outputs_response.status.code != status_code_pb2.SUCCESS:
        raise Exception("Post model outputs failed, status: " +
                        post_model_outputs_response.status.description)

    # Since we have one input, one output will exist here.
    output = post_model_outputs_response.outputs[0]

    print("Predicted concepts:")
    tempdic = {}
    for concept in output.data.concepts:
        # print(concept)
        # print("%s %.2f" % (concept.name, concept.value))
        tempdic[concept.name] = "%.2f" % concept.value

    # json_object = json.dumps(tempdic) 
    return tempdic
    # return json_object

views = Blueprint('views', __name__)

@views.route('/',methods=["GET","POST"])
def home():
    data = request.form
    print(data)
    return render_template("home.html")

@views.route('/ana/<path:link>',methods=["GET","POST"])
def analyse(link):
    print(link)
    json_obj = imgapi(link)
    return render_template("home.html",text=json_obj,boolean=True)