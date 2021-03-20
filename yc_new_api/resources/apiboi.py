from clarifai_grpc.channel.clarifai_channel import ClarifaiChannel
from clarifai_grpc.grpc.api import resources_pb2, service_pb2, service_pb2_grpc
from clarifai_grpc.grpc.api.status import status_pb2, status_code_pb2
import json

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
                        url="https://assets.epicurious.com/photos/57c5c6d9cf9e9ad43de2d96e/6:4/w_620%2Ch_413/the-ultimate-hamburger.jpg"
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

json_object = json.dumps(tempdic) 
print(json_object)