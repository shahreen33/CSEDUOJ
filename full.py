#!/usr/bin/env python

import sys
import getpass
import os
import re
import requests
import re
from bs4 import BeautifulSoup

global version
if (sys.version_info > (3,0)):
    raw_input = input
    version = False
else:
    version = True

def login(login_url):
    star()
    name = raw_input("Enter your spoj username: ")
    password = getpass.getpass()
    star()
    start_session(login_url, name, password)

def start_session(login_url, username, password):
    print ('Verifying....')
    global session, user
    user = username
    with requests.Session() as session:
        payload = {
                'login_user' : username,
                'password' : password,
                'submit': 'login',
                }
        r = session.post(login_url, data = payload)
        html = r.text
        html.encode('utf-8')
        soup = BeautifulSoup(html, 'html.parser')

        '''Check for the authentication of the user. After the login is successful, the problems submitted by the user and the todo
              problems are stored in submitted_problems and todo_problems respectively which are a list of tuples storing in format
              (problem, problem_status_by_user_link).
        '''
        for auth in soup.find_all('h3'):
            if (auth.get_text() == 'Authentication failed!'):
                print ('Authentication Failed!')
                print ('Enter login credentials again!')
                login(login_url)
                break
        else:
            soup = return_html('http://www.spoj.com/myaccount/')
            tables = soup.find_all('table')
            global submitted_problems,todo_problems
            submitted_problems = read_problems(tables[0])
            todo_problems = read_problems(tables[1])

            read_from_user()

def read_problems(table):
    # function to read all submiited problems and todo problems
    problems = []
    for row in table.find_all('tr'):
        for col in row.find_all('a'):
            problems.append((col.get_text(), col.get('href')))
    # Strip out empty tuples
    return sorted(list(filter(lambda x: x[0], problems)))

def show_problems():
    while (True):
        star()

        options = { 1 : classical_problems,
                    2 : challenge_problems,
                    3 : partial_problems,
                    4 : tutorial_problems,
                    5 : riddle_problems,
                    6 : basic_problems,
                    7 : find_tags,
                    8 : read_from_user,
                    9 : sys.exit,
                }
        print ('1. Classical\n\
2. Challenge\n\
3. Partial\n\
4. Tutorial\n\
5. Riddle\n\
6. Basics\n\
7. Problem by tags\n\
8. Back\n\
9. Exit\n')
        try:
            choice = int(raw_input('Enter your choice[1-9](0 for back) : '))
            if (choice == 0):
                break
            star()
            options[choice]()
        except (ValueError, KeyError):
            print ('Wrong choice! Enter Again.')

def classical_problems():
    choices(url + '/problems/classical/unsolved/')

def challenge_problems():
    choices(url + '/problems/challenge/unsolved/')

def partial_problems():
    choices(url + '/problems/partial/unsolved/')

def tutorial_problems():
    choices(url + '/problems/tutorial/unsolved/')

def choices(link):
    while (True):
        star()

        options = {  1 : '5',
                     2 : '2',
                     3 : '11',
                     4 : '6',
                     5 : '7',
                     6 : '9',
                     7 : '10',
                  }

        print ('1. Sorted by ID\n\
2. Sorted by Name\n\
3. Sorted by Quality\n\
4. Sorted by Users\n\
5. Sorted by Accuracy\n\
6. Sorted by Concept Difficulty\n\
7. Sorted by Implementation Difficulty\n\
8. Exit\n')

        choice = make_choice(8)
        if(choice == 0):
            break
        elif (choice == 8):
            sys.exit()

        star()
        print ('1. Increasing Order\n\
2. Decreasing Order\n')
        ch = make_choice(2)
        star()
        urll = link + 'sort='
        if (ch == 2):
            urll += '-'
        if(ch != 0):
            urll += options[choice]
            choice = list_problems(urll)

def list_problems(link, start = 0, last = False):
    link += (',start=' + repr(start))
    problems = extract_problems(link)
    while (True):
        display8(problems)
        if (len(problems) < 50):
            last = True
        star()
        try:
            if (start>0):
                print ('       -1. | Last 50 problems')
            print ('        0. | Back')
            if (not last):
                print ('      100. | Next 50 problems')
            print ('[1 : {} ]. | For problem to open'.format(len(problems)))
            choice = int(raw_input('Enter your choice : '))

            star()
            if ((start == 0 and choice == -1) or (choice < -1) or (choice > len(problems) and choice != 100) or (last and choice == 100)):
                raise ValueError
            elif (choice == -1):
                break
            elif (choice == 100):
                choice = list_problems(link, start+50)
            elif (choice != 0) :
                open_problem(url + problems[choice - 1][-1], problems[choice - 1])
            star()

            if (choice == 0):
                return choice

        except ValueError:
            print ('Wrong Input!Try Again!')
            star()

def riddle_problems():
    problems_riddle = extract_problems(url + '/problems/riddle/unsolved/')
    while (True):
        display8(problems_riddle)

        choice = make_choice(len(problems_riddle))
        if (choice == 0):
            break

        open_problem(url + problems_riddle[choice - 1][-1],problems_riddle[choice - 1])

def basic_problems():
    problems_basic = extract_problems(url + '/problems/basics/unsolved/')
    while (True):
        display8(problems_basic)

        choice = make_choice(len(problems_basic))
        if (choice == 0):
            break

        open_problem(url + problems_basic[choice - 1][-1], problems_basic[choice - 1])

def find_tags():
    soup = return_html(url + '/problems/tags')
    rows = soup.find('table').find('tbody').find_all('tr')

    tags = []   #tags is list of tuples in format (tag name, count of problems, tag link) that stores all tags

    for columns in rows:
        col = columns.find_all('td')
        link = col[0].find('a')
        tags.append((link.get_text(), col[1].get_text(), link.get('href')))
    tags = list(filter(lambda x: int(x[1]) > 0, tags))

    choose_tag(tags)

def choose_tag(tags):
    while (True):
        print ('{:<40}||{:^50}||{:>40}\n\n'.format('INDEX', 'TAGS', 'PROBLEMS'))
        display2(tags)
        choice = make_choice(len(tags))
        if (choice == 0):
            break

        tag_problems = extract_problems(url + tags[choice - 1][-1])
        # tag_problems store all the problems associated with the chosen tag

        while (True):
            display8(tag_problems)
            choice = make_choice(len(tag_problems))
            if (choice == 0):
                break

            open_problem(url + tag_problems[choice - 1][-1] + '/', tag_problems[choice - 1])

def make_choice(l):
    try:
        choice = int(raw_input('Enter your choice[1 : {}] (0 for back) : '.format(l)))
        star()
        if (choice < 0 or choice > l):
            raise ValueError
    except ValueError:
        star()
        print ('Wrong Input!Enter Again!')
        star()
        return make_choice(l)

    return choice

def extract_problems(link):
    r = session.get(link)
    soup = BeautifulSoup(r.text.encode('utf-8'), 'html.parser')
    rows = soup.find('tbody').find_all('tr')

    problems = []
    # problems is a list of tuples in format(ID, NAME, QUALITY, USERS, IMPLEMENTATION, CONCEPT, PROBLEM_LINK)

    for row in rows:
        quality,implementation,concept = None,None,None
        columns = row.find_all('td')
        ind = columns[1].get_text().strip()
        problem_link = columns[2].find('a')
        if (columns[3].find('span')):
            quality = columns[3].find('span').get_text().strip()
        submissions = columns[4].find('a').get_text()
        accuracy = columns[5].find('a').get_text()
        difficulty = columns[6].find('div').find_all('div')
        if (len(difficulty) > 0 and difficulty[0].find('span')):
            implementation = difficulty[0].find('span').get_text()
        if (len(difficulty) > 1 and difficulty[1].find('span')):
            concept = difficulty[1].find('span').get_text()
        name = problem_link.get_text().strip()
        if (version):
            name = name.encode('utf-8')
        if (ind == '6681'):
            name = "".join(re.findall("[a-zA-Z]+", name))
        problems.append((ind, name, quality, submissions, accuracy, implementation, concept, problem_link.get('href')))
    return problems

def open_problem(link, tup, sizeis2 = True):
    # Function that extracts problem statement, input description ,output description and test-cases
    print ('\n\n\n\n\n')
    star()
    if (link.endswith('/')):
        soup = return_html(link + 'en/', True)
    else:
        soup = return_html(link + '/en/', True)
    problem_name = soup.find("h2", {"id" : "problem-name"}).get_text()
    print ('{:^130}'.format(problem_name))
    star()

    statement = soup.find("div", {"id" : "problem-body"})
    print (statement.get_text())
    star()

    problem_meta = soup.find("table", {"id" : "problem-meta"}).find_all('tr')
    for row in problem_meta:
        col = row.find_all('td')
        print (col[0].get_text() + " : " + col[1].get_text())
    if (sizeis2):
        options_after_open_problem(link, tup[-1].encode('ascii').rstrip('/').split('/')[-1])
    else:
        options_after_open_problem(link, tup[0])

def options_after_open_problem(link, name):
    while (True):
        star()

        print ('1. Open problem in webbrowser\n\
2. Submit solution\n\
3. My status\n\
4. Problem Statistics\n\
5. Exit\n')

        choice = make_choice(5)
        if(choice == 0):
            break
        elif (choice == 1):
            import webbrowser
            webbrowser.open_new(link)
        elif (choice == 2):
            submit_solution(name)
        elif (choice == 3):
            my_status(url + '/status/' + name + ',' + user + '/')
        elif (choice == 4):
            soup = return_html(url + '/ranks/' + name + '/')
            try:
                stats = soup.find("table").find_all('tr')
                star()
                for head,cont in zip([h.get_text() for h in stats[0].find_all('th')] , [c.get_text() for c in stats[1].find_all('td')]):
                    if (version):
                        print (head.encode('ascii') + " : " + cont.encode('ascii'))
                    else:
                        print (head + " : " + cont)
            except AttributeError:
                print ('Sorry request cannot be processed. Server is busy.')
        else:
            sys.exit()

        star()

def my_status(link, check = False, accepted = False):
    r = session.get(link)
    html = r.text.encode('utf-8').replace('</td></td>', '</td>')
    soup = BeautifulSoup(html, 'html.parser')
    rows = soup.find('table', {'class': 'problems'}).findAll('tr')
    if (check):
        col = rows[1].find_all('td')
        status = col[4].text.replace('edit', ' ').replace('ideone it', ' ').strip()
        print (" ".join(status.split("\n")))
        if (status.startswith('running') or status.startswith('compiling')):
            return False
        else:
            return True
    submissions = []
    for ind,row in enumerate(rows):
        if (ind == 0):
            col = row.findAll('th')
            sub_id = col[0].text
            time = col[5].text
        else:
            try:
                col = row.findAll('td')
                sub_id = col[0].find('a').text.strip()
                time = col[5].find('a').text.strip()
            except IndexError:
                return
        date = col[2].text.strip()
        name = col[3].text.strip()
        status = col[4].text.replace('edit', '').replace('ideone it', '').strip()
        mem = col[6].text.strip()
        lang = col[7].text.strip()
        submissions.append((sub_id, date, name, status, time, mem, lang))

    submissions = submissions[1:]
    if (accepted):
        return [x[0] for x in submissions if x[3] == 'accepted']
    if (len(submissions) == 0):
        return

    while (True):
        star()
        print ('{:^10}|{:^10}|{!s:^25s}|{!s:^30}|{!s:^30}|{!s:^10}|{!s:^10}|{!s:^15}\
                \n'.format('INDEX', 'ID', 'DATE', 'NAME', 'RESULT', 'TIME','MEM', 'LANG'))
        for index,p in enumerate(submissions):
            print ('{:^10}|{:^10}|{!s:^25s}|{!s:^30}|{!s:^30}|{!s:^10}|{!s:^10}|{!s:^15}\
                    '.format(index+1, p[0], p[1], p[2], p[3], p[4], p[5], p[6]))
        star()
        try:
            choice = int(raw_input('Enter which solution to display[1 : {}] (0 for back) : '.format(len(submissions))))
            star()
            if(choice == 0):
                break
            elif (choice < 0 or choice > len(submissions)):
                raise ValueError
            else:
                print ('\n\n\n\n')
                star()
                print ('{:^130}'.format('SOLUTION'))
                star()
                print (display_code(url + '/submit/' + link.split('/')[4].split(',')[0] + '/id=' + submissions[choice - 1][0]))
        except ValueError:
            star()
            print ('Wrong Input!Enter Again!')
            star()

def display_code(link):
    #Function that extracts code submitted to the problem
    soup = str(session.get(link).text)
    return  "".join([x for x in re.findall('<textarea.*?>(.*)</textarea>', soup, re.MULTILINE | re.DOTALL)])

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

def choose(tup):
    while (True):
        display(tup)
        choice = make_choice(len(tup))
        if (choice == 0):
            break
        open_problem(url + '/problems/' + tup[choice - 1][0] + '/', tup[choice - 1], False)

def display(tup):
    if (len(tup) == 0):
        return
    print ('\n\t\t{:<30}||{:>30}\n'.format("INDEX", "PROBLEM"))
    for index,p in enumerate(tup):
        print ('\t\t{:<30}||{:>30}\n'.format(index+1, p[0]))
    star()

def display2(tup):
    if (len(tup) == 0):
        return
    for index,p in enumerate(tup):
        print ('{:<40}||{:^50}||{:>40}\n'.format(index+1 ,p[0] ,p[1]))
    star()

def display8(tup):
    if (len(tup) > 0):
        print ('{:^10}|{:^10}|{:^55}|{:^10}|{:^15}|{:^10}|{:^20}|{:^10}\n'.format("NUMBER", "ID", "NAME", "QUALITY", "USERS", "ACCURACY", "IMPLEMENTATION", "CONCEPT"))
    for index,p in enumerate(tup):
        print ('{:^10}|{:^10}|{!s:^55s}|{!s:^10}|{!s:^15}|{!s:^10}|{!s:^20}|{!s:^10}'.format(index+1, p[0], p[1], p[2], p[3], p[4], p[5],p[6]))
    star()

def submit_solution(name, ask_problem = False):
    while (True):
        link = url + '/submit/complete/'
        try:
            if (ask_problem):
                name = raw_input('Enter Problem Code : ')
            filepath = raw_input('Enter the path of the solution file : ')
            if (not os.path.isfile(filepath)):
                raise IOError
            payload = dict(problemcode = name, lang = language(name), file = open(filepath, 'rb').read(), submit = "Send")
            r = session.post(link, data = payload)
            sub_id = re.search(r'"newSubmissionId" value="(\d+)"/>', r.text).group(1)
        except AttributeError:
            print ('Wrong ProblemCode!Enter Again!')
            star()
        except IOError:
            print ("FilePath is not valid!Enter Again!")
            star()
        else:
            break

    while (True):
        if (my_status(url + '/status/' + name + ',' + user + '/', check = True)):
            break
    my_status(url + '/status/' + name + ',' + user + '/')

def language(name):
    link = url + '/submit/' + name + '/'
    soup = return_html(link)
    lang = soup.findAll('option')

    options = dict()
    for ind,option in enumerate(lang):
        text = str(option)
        options[ind] = ["".join(re.findall('<option.*?>(.*)</option>', text)), "".join(re.findall('^<option value="(.*)">', text))]

    if (len(options) == 0):
        return '0'

    while (True):
        star()
        for key in options.keys():
            print ('\t\t{:<20}||{:>40}\n'.format(key, options[key][0]))
        try:
            choice = int(raw_input("Choose the language[ 0 : {} ] :  ".format(len(options) - 1)))
            if (choice < 0 or choice + 1 > len(options)):
                raise ValueError
        except ValueError:
            print ('Wrong choice!Enter Again!\n')
        else:
            break

    star()
    return options[choice][1]

def download_solutions():
    try:
        path = raw_input('Enter the directory to store solutions : ')
        if (not os.path.exists(path)):
            os.mkdir(path)
        if (not os.path.isdir(path)):
            raise RuntimeError
    except Exception as e:
        print (e)
        sys.exit(1)
    os.chdir(path)
    for problem in [x[0] for x in submitted_problems]:
        print ('Downloading solutions of ' + problem)
        for sol_id in my_status(url + '/status/' + problem + "," + user + '/', accepted = True):
            filename = problem + "-" + sol_id
            code = display_code(url + '/submit/' + problem + '/id=' + sol_id)
            with open(filename, 'w') as f:
                f.write(code)

def read_from_user():
    while (True):
        star()

        print ('1. Show problems\n\
2. Submit solution\n\
3. Show submitted problems by the user\n\
4. Show todo problems\n\
5. Download all solutions to AC problems by user\n\
6. See problems submitted by some other user(Displays only the problems AC\'d by other user)\n\
7. Exit\n')
        try:
            choice = int(raw_input('Enter your choice[1-7] : '))
            star()
            if (choice == 1):
                show_problems()
            elif (choice == 2):
                submit_solution('', True)
            elif (choice == 3):
                choose(submitted_problems)
            elif (choice == 4):
                choose(todo_problems)
            elif (choice == 5):
                download_solutions()
            elif (choice == 6):
                while (True):
                    try:
                        frnd_name = raw_input("Enter username: ")
                        table = return_html(url + '/users/' + frnd_name + '/').find('table')
                        problems = read_problems(table)
                        if (len(problems) == 0):
                            raise AttributeError
                    except AttributeError:
                        print ('Username is not valid!Enter again!')
                        star()
                    else:
                        break

                star()
                filter_list = [name[0] for name in submitted_problems]
                problems = list(filter(lambda x: x[0] not in filter_list, problems))
                choose(problems)
            elif (choice == 7):
                break
            else:
                raise ValueError
        except ValueError:
            print ('Wrong choice! Enter Again.')

def star():
	rows,cols = os.popen('stty size','r').read().split()
	cols = int(cols)
	print( '\n' +  '*'*cols + '\n' )

def main():
    global url
    url = "http://www.spoj.com"
    star()
    print ('\t\t\t\t\t\t\tFull Screen Recommended')
    login(url + '/login')

if __name__ == '__main__':
    main()