import requests

# Azure Translator API credentials
subscription_key = '1f76e54d247349faaeaf20def1196ab4'  # Replace with your actual API key
endpoint = 'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0'

# Azure region
location = 'centralindia'  # Adjust as necessary

def translate(text_list, target_language):
    headers = {
        'Ocp-Apim-Subscription-Key': subscription_key,
        'Ocp-Apim-Subscription-Region': location,
        'Content-type': 'application/json'
    }
    body = [{'Text': text} for text in text_list]  # Create body for each text

    # Construct the URL with the target language
    constructed_url = f"{endpoint}&to={target_language}"

    try:
        # Send the POST request
        response = requests.post(constructed_url, headers=headers, json=body)
        
        # Check if the response was successful
        if response.status_code != 200:
            print(f"Error: {response.status_code} - {response.text}")
            return None
        
        # Ensure the response is in JSON format
        response_data = response.json()

        # Extract the translated texts if available
        translated_texts = [item['translations'][0]['text'] for item in response_data]
        return translated_texts

    except Exception as e:
        print(f"An unexpected error occurred: {e}")
        return None

# Example usage
if __name__ == "__main__":
    text_to_translate = ["Hello, world!", "How are you?"]  # Text you want to translate
    target_language = "es"  # Target language code (Spanish)
    
    translated = translate(text_to_translate, target_language)
    
    if translated:
        print("Translated text:", translated)
    else:
        print("Translation failed.")
