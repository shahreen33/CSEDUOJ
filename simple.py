import time
import os
import requests
import re
import sys
from bs4 import BeautifulSoup
time.sleep(1)
html = 'df'
soup = BeautifulSoup(html, 'html.parser')
print soup