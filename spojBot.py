import os
import requests
import re
import sys
import time
from bs4 import BeautifulSoup

verdict = "Submission Failed"
errorLog = open('errorLog.txt', 'a')
def login(login_url, name, password):
    return start_session(login_url, name, password)

def start_session(login_url, username, password):
        #print ('Verifying....')
        global session, user
        user = username
        with requests.Session() as session:
            payload = {
                'login_user': username,
                'password': password,
                'submit': 'login',
            }
            r = session.post(login_url, data=payload)

            html = r.text
            html.encode('utf-8')
            soup = BeautifulSoup(html, 'html.parser')

            '''Check for the authentication of the user. After the login is successful, the problems submitted by the user and the todo
                  problems are stored in submitted_problems and todo_problems respectively which are a list of tuples storing in format
                  (problem, problem_status_by_user_link).
            '''
            #print soup
            for auth in soup.find_all('h3'):
                if (auth.get_text() == 'Authentication failed!'):
                    errorLog.write("Cannot login\n")
                    global verdict
                    verdict = "Internal Error"
                    return False
            return True

def submit_solution(name, language, filepath):
        link = url + '/submit/complete/'
        print language
        print name
        try:
            if (not os.path.isfile(filepath)):
                raise IOError
            payload = dict(problemcode = name, lang = language, file = open(filepath, 'rb').read(), submit = "Send")
            r = session.post(link, data = payload)
        except IOError:
            errorLog.write ("FilePath is not valid!Enter Again!\n")
            return
        time.sleep(1)
        print "got to  here"
        getVerdict(url + '/status/' + name + ',' + user + '/')
        '''while (True):
            if (my_status(url + '/status/' + name + ',' + user + '/', check = True)):
                break
            my_status(url + '/status/' + name + ',' + user + '/')
        '''

def getVerdict(link):
    r = session.get(link)
    html = r.text.encode('utf-8').replace('</td></td>', '</td>')
    soup = BeautifulSoup(html, 'html5lib')

    rows = soup.find('table', {'class': 'problems'}).findAll('tr')
    col = rows[1].find_all('td')

    status = col[4].text.replace('edit', ' ').replace('ideone it', ' ').strip()
    if(status.startswith('waiting')):
        time.sleep(1)
        return getVerdict(link)
    elif(status.startswith('compiling')):
        time.sleep(1)
        return getVerdict(link)
    elif(status.startswith('running')):
        time.sleep(3)
        return getVerdict(link)
    global verdict
    verdict = status

def main():
    '''
    argv[1] is problem code/number
    argv[2] is source code directory
    argv[3] is language
    :return: 
    '''
    #print 'fine'
    problemCode = sys.argv[1]
    filename = sys.argv[2]
    language = sys.argv[3]
    #print "Hello everybody"

    global url
    url = "http://www.spoj.com"

    global verdict

   # print ('\t\t\t\t\t\t\tFull Screen Recommended')
    if(login(url + '/login', 'cseduoj1', '123456') == True):
        print("at least here")
        submit_solution(problemCode, language, filename)
    print verdict
if __name__ == '__main__':
    main()
