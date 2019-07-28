raw = open("tradeBlank.txt").read().split('\n')
raw1 = open("data.txt").read().split('\n')
temp = []
for i in range(0,len(raw1)):
    temp.append(raw1[i].split(',')[0])
for i in range(0,len(raw)):
    raw[i] = raw[i].split(',')[0].replace("-"," ")
    if((raw[i] in temp) == False):
        print(raw[i])
        raw1.append(raw[i] + ",0,0,0")
raw1 = '\n'.join(raw1)
open("data.txt","w").write(raw1)
input("Done.")
