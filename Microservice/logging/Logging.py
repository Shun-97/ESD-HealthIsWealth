import requests
import json

query = """mutation MyMutation {
  insert_Logging(objects: {Type: "testagain", Description: "testagain"}) {
    affected_rows
  }
}"""


url = 'https://esd-healthiswell-69.hasura.app/v1/graphql/'
myobj = {'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
         'content-type': 'application/json'}
r = requests.post(url, headers=myobj, json={'query': query})
print(r.status_code)
print(r.text)