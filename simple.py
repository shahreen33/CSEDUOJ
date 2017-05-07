import os
import requests
import re
import sys
import time
from bs4 import BeautifulSoup

verdict = "Submission Failed"
errorLog = open('errorLog.txt', 'a')
print "OKOK"