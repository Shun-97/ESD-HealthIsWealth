import requests
import json


def call_calorieninja(query):
    api_url = 'https://api.calorieninjas.com/v1/nutrition?query='
    response = requests.get(api_url + query, headers={'X-Api-Key': 'REtXb+Q4bQ2JMKCYXL7+3g==urfa511CyFMRg6g0'})
    # if response.status_code == requests.codes.ok:
    #     return(response.text)
    # else:
    #     print("Error:", response.status_code, response.text)


    
    y = json.loads(response.text)
    if y['items'] != []:
        return response.text

    else:
        # error
        return None
    

    
