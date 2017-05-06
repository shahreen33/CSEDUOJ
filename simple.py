import sys
def sum(a):
    b = 32
    ret = 0
    while(a<b):
        ret += 2
        a+=1
    return ret

print sys.argv[1]
#print sum(sys.argv[1])