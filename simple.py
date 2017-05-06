import os
import requests
import re
from bs4 import BeautifulSoup

def login(login_url, name, password):
    start_session(login_url, name, password)

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
                    print ('Authentication Failed!')
                    print ('Enter login credentials again!')
                    login(login_url)
                    break
            else:
                soup = return_html('http://www.spoj.com/myaccount/')



def return_html(link, replace = False):
    r = session.get(link)
    html = r.text
    if (replace):
        page_html = r.text.split('<br')
        for i in range(1,len(page_html)):
            page_html[i] = '\n\n<br' + page_html[i]
        html = "".join(page_html)
    soup = BeautifulSoup(html, 'html.parser')
    return soup
def getLanguageID( lang):
    return 6

def submit_solution(name, lang, filepath):
    while (True):
        link = url + '/submit/complete/'
        try:
            if (not os.path.isfile(filepath)):
                raise IOError
            payload = dict(problemcode = name, lang = getLanguageID(lang), file = open(filepath, 'rb').read(), submit = "Send")
            r = session.post(link, data = payload)
            sub_id = re.search(r'"newSubmissionId" value="(\d+)"/>', r.text).group(1)
        except AttributeError:
            print ('Wrong ProblemCode!Enter Again!')
            #star()
        except IOError:
            print ("FilePath is not valid!Enter Again!")
            #star()
        else:
            break

    '''while (True):
        if (my_status(url + '/status/' + name + ',' + user + '/', check = True)):
            break
    my_status(url + '/status/' + name + ',' + user + '/')
    '''

def main():
    print "Hello fucking everybody"
    global url
    url = "http://www.spoj.com"
   # print ('\t\t\t\t\t\t\tFull Screen Recommended')
    login(url + '/login', 'tanzir_5', 'tanzir.5')
    submit_solution('QTREE', 'C++', 'yo.cpp')

if __name__ == '__main__':
    main()
