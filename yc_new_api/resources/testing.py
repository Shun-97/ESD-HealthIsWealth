from clarifai_grpc.channel.clarifai_channel import ClarifaiChannel
from clarifai_grpc.grpc.api import resources_pb2, service_pb2, service_pb2_grpc
from clarifai_grpc.grpc.api.status import status_pb2, status_code_pb2
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from os import environ
from flask_cors import CORS

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/imgms'#environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['SQLALCHEMY_ENGINE_OPTIONS'] = {'pool_recycle': 299}
db = SQLAlchemy(app)
CORS(app)


class Image(db.Model):
    __tablename__ = 'records'

    name = db.Column(db.String(255), primary_key=True)
    value = db.Column(db.Float(precision=12))
    def __init__(self, name, value):
        self.name = name
        self.value = value


    def json(self):
        return {"name": self.name, "value": self.value}

# app.route("/image")
# def get_all():
#     images = Image.query.all()
#     if len(images):
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": {
#                     "images": [image.json() for image in images]
#                 }
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "message": "There are no image."
#         }
#     ), 404

# @app.route("/image/<string:img>", methods=['POST'])
# def create_image(image):
#     if (Image.query.filter_by(image=image).first()):
#         return jsonify(
#             {
#                 "code": 400,
#                 "data": {
#                     "image": image
#                 },
#                 "message": "Image already exists."
#             }
#         ), 400

#     data = request.get_json()
#     image = Image(image)

#     try:
#         db.session.add(image)
#         db.session.commit()
#     except:
#         return jsonify(
#             {
#                 "code": 500,
#                 "data": {
#                     "image": image
#                 },
#                 "message": "An error occurred creating the image."
#             }
#         ), 500

#     return jsonify(
#         {
#             "code": 201,
#             "data": image.json()
#         }
#     ), 201

# @app.route("/image/<string:image>", methods=['DELETE'])
# def delete_image(image):
#     image = Image.query.filter_by(image=image).first()
#     if image:
#         db.session.delete(image)
#         db.session.commit()
#         return jsonify(
#             {
#                 "code": 200,
#                 "data": {
#                     "image": image
#                 }
#             }
#         )
#     return jsonify(
#         {
#             "code": 404,
#             "data": {
#                 "image": image
#             },
#             "message": "Image not found."
#         }
#     ), 404
@app.route("/records")
def get_all():
    meep = Image.query.all()
    if len(meep):
        return jsonify(
            {
                "code": 200,
                "data": {
                    "books": [book.json() for book in booklist]
                }
            }
        )
    return jsonify(
        {
            "code": 404,
            "message": "There are no books."
        }
    ), 404

@app.route("/upload", methods=['POST'])
def upload_input(jsonss):
    name = jsonss.name
    print(name)
    if (Image.query.filter_by(name=name).first()):
        return jsonify(
            {
                "code": 400,
                "data": {
                    "name": name,
                },
                "message": "input already exists."
            }
        ), 400

    image = Image(name, jsonss.value)
    try:
        db.session.add(image)
        db.session.commit()
    except:
        return jsonify(
            {
                "code": 500,
                "data": {
                    "image": image
                },
                "message": "An error occurred creating the image."
            }
        ), 500

    return jsonify(
        {
            "code": 201,
            "data": {
                "name": name,
                "value": jsons.value
            }
        }
    ), 201

# Note: You can also use a secure (encrypted) ClarifaiChannel.get_grpc_channel() however
# it is currently not possible to use it with the latest gRPC version
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
for concept in output.data.concepts:
    # print(concept)
    # print("%s %.2f" % (concept.name, concept.value))
    print("1")



if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)