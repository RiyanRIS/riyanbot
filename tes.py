import requests

headers = {
    'accept': '*/*',
    'api_key': 't]z-8Dkyf^nD7iZB9GJI{T\$K1[S[s?',
    'Content-Type': 'application/json',
}

data = '{"args":{"contactId":"628226627296@c.us"}}'
res = requests.post(
    'https://riyanapiwa.herokuapp.com/checkNumberStatus', headers=headers, data=data)

print(res)
