import os
import requests
import re
import sys
import time
from bs4 import BeautifulSoup

verdict = "Submission Failed"
#errorLog = open('errorLog.txt', 'a')
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
                    #errorLog.write("Cannot login\n")
                    global verdict
                    verdict = "Internal Error"
                    return False
            return True

def submit_solution(name, language, filepath):
        link = url + '/submit/complete/'
        try:
            if (not os.path.isfile(filepath)):
                raise IOError
            payload = dict(problemcode = name, lang = language, file = open(filepath, 'rb').read(), submit = "Send")
            r = session.post(link, data = payload)
            sub_id = re.search(r'"newSubmissionId" value="(\d+)"/>', r.text).group(1)
        except AttributeError:
            #errorLog.write ('Wrong ProblemCode!Enter Again!\n')
            return
        except IOError:
            #errorLog.write ("FilePath is not valid!Enter Again!\n")
            return
        time.sleep(1)
        #my_status(url + '/status/' + name + ',' + user + '/', check=True)
        '''while (True):
            if (my_status(url + '/status/' + name + ',' + user + '/', check = True)):
                break
            my_status(url + '/status/' + name + ',' + user + '/')
        '''

'''def my_status(link, check=False, accepted=False):
    r = session.get(link)
    html = r.text.encode('utf-8').replace('</td></td>', '</td>')
    soup = BeautifulSoup(html, 'html.parser')

    rows = soup.find('table', {'class': 'problems'}).findAll('tr')
    if (check):
        col = rows[1].find_all('td')

        status = col[4].text.replace('edit', ' ').replace('ideone it', ' ').strip()
        if(status.startswith('waiting')):
            time.sleep(1)
            return my_status(link, check)
        elif(status.startswith('compiling')):
            time.sleep(1)
            return my_status(link,check)
        elif(status.startswith('running')):
            time.sleep(3)
            return my_status(link, check)
        global verdict
        verdict = status
'''
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
        submit_solution(problemCode, language, filename)
    print verdict
if __name__ == '__main__':
    main()
