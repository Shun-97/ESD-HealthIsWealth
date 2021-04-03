from dietapi import call_calorieninja
import json

query = 'carrot' # input by user, do later
results = call_calorieninja(query)

if results == None: # error message
    print("Error: Item Not Found!")

else: # item found, put everything into 'search_result'
    items = json.loads(results)["items"]
    search_result = items[0]


    print(search_result)

