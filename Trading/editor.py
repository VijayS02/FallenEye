raw = open("data.txt").read().split('\n')
for i in range(0,len(raw)):
    raw[i] = raw[i].split(',')[0]
    raw[i] = raw[i] + ",0,0,0"
raw = '\n'.join(raw)
open("data.txt","w").write(raw)
