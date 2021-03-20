from clarifai.rest import ClarifaiApp

app = ClarifaiApp(api_key='f1b91994ff22442b97d4b07eb0089d9b')
model = app.public_models.general_model
response = model.predict_by_url(url='https://samples.clarifai.com/metro-north.jpg')

