from urllib.request import urlopen,Request
from xml.dom import minidom
import os

# Create directory
dirName = 'raw'
 
try:
    os.mkdir(dirName)
    print("raw Created ") 
except FileExistsError:
    print("raw already exists")

dirName = 'items'
 
try:
    os.mkdir(dirName)
    print("parsed Created ") 
except FileExistsError:
    print("parsed already exists")

    
getXmls = 'https://ae.rotf.io/xmls/getXmlNames'

response = Request(getXmls,headers={'User-Agent': 'Mozilla/5.0'})
webContent = urlopen(response).read()

xml_files = webContent.decode("utf-8").split(":")

rawData = []

print("XML File data collected.")
print("Downloading xml data.")
import progressbar
bar = progressbar.ProgressBar(maxval=len(xml_files), \
    widgets=[progressbar.Bar('=', '[', ']'), ' ', progressbar.Percentage()])
bar.start()
i =0
ignored = []
for fileInd in range(0,len(xml_files)):
    file = xml_files[fileInd]
    #print(file)
    xmlURL = 'https://ae.rotf.io/xmls/'+file

    response = Request(xmlURL,headers={'User-Agent': 'Mozilla/5.0'})
    webContent = urlopen(response).read()

    xml_data = webContent
    doc = minidom.parseString(xml_data)

    items = doc.getElementsByTagName('objects')


    elements = doc.getElementsByTagName('Object')
    for i in range(0,elements.length):
            elementData = elements.item(i)
            if(elementData.getElementsByTagName("Item").length  == 1 and elementData.getElementsByTagName("Soulbound").length ==0 and elementData.getElementsByTagName("IsRestricted").length ==0  ):
                title = elementData.getAttribute("id").replace(":","_)_").replace(" ","-")
                classVal = elementData.getElementsByTagName("Class").item(0).childNodes.item(0).data
                uniqId = elementData.getAttribute("type")
                try:
                    file = elementData.getElementsByTagName("Texture").item(0).getElementsByTagName("File").item(0).childNodes.item(0).data
                    loc = elementData.getElementsByTagName("Texture").item(0).getElementsByTagName("Index").item(0).childNodes.item(0).data
                    rawData.append([title,classVal,file,loc,uniqId])
                except:
                    if(elementData.getElementsByTagName("IsRestricted").length  != 1):
                        ignored.append(title)
                        
                    else:
                        ignored.append("Restricted : " + title)
            elif(elementData.getElementsByTagName("IsRestricted").length != 0):
                title = elementData.getAttribute("id").replace(":","__")
                ignored.append("Restricted : " + title)
                        
    bar.update(fileInd)


bar.finish()
print("DONE!")
print("Storing xml data.")
ignoredFile = open('ignoredItems.txt','w')
ignoredFile.write('\n'.join(ignored))
ignoredFile.close()
for i in range(0,len(rawData)):
    rawData[i] = ','.join(rawData[i])
rawData = '\n'.join(rawData)

f = open('items/data.txt','w')

f.write(rawData)
f.close()
print("Reading xml data.")
f = open("items/data.txt").read().split("\n")
for i in range(0,len(f)):
    f[i] = f[i].split(',')
rawData = f
files = []
for i in range(0,len(rawData)):
    rawData[i][2] = rawData[i][2].replace("new","")
    if((rawData[i][2] in files)==False):
        files.append(rawData[i][2])
    if( type(rawData[i][3]) != str):
        print(rawData[i][3])

rawData = sorted(rawData,key=lambda x: x[3])
rawData = sorted(rawData,key=lambda x: x[2])
print(files)

print("Correcting xml data.")
from collections import Counter
#remove duplicates and fixes list
seen = set()
result = []
for lst in rawData:
    current = frozenset(Counter(lst).items())
    if current not in seen:
        result.append(lst)
        seen.add(current)
rawData = result

for item in rawData:
    if(len(item[3]) >5 ):
        print(item)
print("No corrupted items.")

print("Downloading image files...")

bar = progressbar.ProgressBar(maxval=len(files), \
    widgets=[progressbar.Bar('=', '[', ']'), ' ', progressbar.Percentage()])
bar.start()
i = 0;
for file in files:
    response = Request('https://ae.rotf.io/sheets/EmbeddedAssets_'+file+'Embed_.png',headers={'User-Agent': 'Mozilla/5.0'})
    webContent = urlopen(response).read()

    f = open('raw/'+file+'Embed.png','wb')
    bar.update(i)
    i=i+1


    f.write(webContent)
    f.close()
bar.finish()


print("Splicing image files...")
import cv2
import numpy as np
src = cv2.imread('raw/lofiObj5Embed.png', cv2.IMREAD_UNCHANGED)
cur = "lofiObj5"
height = src.shape[0]
width = src.shape[1]
hexNum = 16
itmSqr = int(height/hexNum)
for item in rawData:
     if( "lofiObj" in item[2] ):
            if(cur != item[2]):
                print(cur)
                src = cv2.imread('raw/'+item[2]+'Embed.png', cv2.IMREAD_UNCHANGED)
                cur = item[2]
            #print(int(item[3][len(item[3])-2],16),int(item[3][len(item[3])-1],16))
            val = int(item[3],16)
            curposx = (val%16)*itmSqr
            curposy = (val//16)*itmSqr
            endposx = curposx + itmSqr
            endposy = curposy + itmSqr
            gray = src[curposy:endposy,curposx:endposx]
            cv2.imwrite("parsed/"+item[0]+".png", gray)

print("The whole process finished.")
input()
input()
