from flask import Flask, request, jsonify
import requests
import os

app = Flask(__name__)

# Azure Translator credentials
AZURE_TRANSLATOR_KEY = "1f76e54d247349faaeaf20def1196ab4"
AZURE_TRANSLATOR_ENDPOINT = "https://api.cognitive.microsofttranslator.com/translate?api-version=3.0"

@app.route('/translate', methods=['POST'])
def translate():
    # Get the request data
    data = request.json
    text = data.get('text', [])
    target_language = data.get('target_language', 'en')

    # Prepare the request for the Azure Translator API
    headers = {
        'Ocp-Apim-Subscription-Key': AZURE_TRANSLATOR_KEY,
        'Ocp-Apim-Subscription-Region': 'YOUR_RESOURCE_REGION',  # If applicable
        'Content-Type': 'application/json'
    }
    translate_url = f"{AZURE_TRANSLATOR_ENDPOINT}/translate?api-version=3.0&to={target_language}"

    # Prepare the payload
    body = [{'text': t} for t in text]

    # Make the request to the Azure Translator API
    response = requests.post(translate_url, headers=headers, json=body)
    translated_data = response.json()

    # Extract the translated text
    translated_text = [item['translations'][0]['text'] for item in translated_data]

    # Return the translated text
    return jsonify(translated_text=translated_text)

if __name__ == '__main__':
    app.run(debug=True)
