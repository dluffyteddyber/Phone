from bs4 import BeautifulSoup
import requests
import pandas as pd
seed_url = 'https://www.amazon.com/Apple-iPhone-Pro-128GB-Silver/dp/B08PNB9B5Z/ref=sr_1_4?crid=22A554CA43W0A&keywords=iPhone+14+Pro&qid=1693043337&sprefix=iphone+14+pro%2Caps%2C268&sr=8-4'
response = requests.get(seed_url)
response.status_code  # 200 means the request is accepted
soup = BeautifulSoup(response.content, 'html.parser')

Name_of_the_item = []
Price_of_the_item = []

for soup in results:
    try:
        Name_of_the_item.append(
            soup.find('a', {'class': 'item-title'}).get_text())
    except:
        Name_of_the_item.append('n/a')
    try:
        Price_of_the_item.append(
            soup.find('li', {'class': 'price-current'}).get_text())
    except:
        Price_of_the_item.append('n/a')
