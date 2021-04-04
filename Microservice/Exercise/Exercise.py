import requests 
import json 

query = """query MyQuery {
  ExerciseFatty_Exercises {
    calories_burnt
    Description
    exercise_id
    exercise_time
    exercise_type
    type
  }
}"""


url = 'https://esd-healthiswell-69.hasura.app/v1/graphql/'
myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk', 'content-type': 'application/json'}
r = requests.post(url=url, headers=myobj, json={'query': query})
print(r.status_code)
print(r.text)