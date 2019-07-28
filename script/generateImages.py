from urllib.request import urlopen,Request
from xml.dom import minidom
import os
import sys
def install_and_import(package):
    import importlib
    try:
        importlib.import_module(package)
    except ImportError:
        import pip
        pip.main(['install', package])
    finally:
        globals()[package] = importlib.import_module(package)

install_and_import("progressbar")
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
blacklist = open('blacklist.txt').read().split("\n")
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
if(input("Re-load item data?\n") == "y"):
    i = 0
    ignored = []
    for fileInd in range(0, len(xml_files)):
        file = xml_files[fileInd]
        # print(file)
        xmlURL = 'https://ae.rotf.io/xmls/' + file

        response = Request(xmlURL, headers={'User-Agent': 'Mozilla/5.0'})
        webContent = urlopen(response).read()

        xml_data = webContent
        doc = minidom.parseString(xml_data)

        items = doc.getElementsByTagName('objects')

        elements = doc.getElementsByTagName('Object')
        for i in range(0, elements.length):
            elementData = elements.item(i)
            if (elementData.getElementsByTagName("Item").length == 1 and elementData.getElementsByTagName(
                    "Soulbound").length == 0 and elementData.getElementsByTagName("IsRestricted").length == 0):
                title = elementData.getAttribute("id").replace(":", "_").replace(" ", "-")
                classVal = elementData.getElementsByTagName("Class").item(0).childNodes.item(0).data
                uniqId = elementData.getAttribute("type")
                try:

                    file = elementData.getElementsByTagName("Texture").item(0).getElementsByTagName("File").item(
                        0).childNodes.item(0).data
                    if (file in blacklist):
                        print("BlackListed: " + file)
                        ignored.append("Blacklisted : " + title + " By File: " + file )
                    elif(elementData.getAttribute("id") in blacklist):
                        print("Blacklisted: " + elementData.getAttribute("id"))
                        ignored.append("Blacklisted : " + title)
                    else:
                        loc = elementData.getElementsByTagName("Texture").item(0).getElementsByTagName("Index").item(
                            0).childNodes.item(0).data
                        rawData.append([title, classVal, file, loc, uniqId])
                except:
                    if (elementData.getElementsByTagName("IsRestricted").length != 1):
                        ignored.append(title)
                    else:
                        ignored.append("Restricted : " + title)
            elif (elementData.getElementsByTagName("IsRestricted").length != 0):
                title = elementData.getAttribute("id").replace(":", "__")
                ignored.append("Restricted : " + title)

        bar.update(fileInd)

    bar.finish()
    print("DONE!")
    print("Storing xml data.")
    ignoredFile = open('ignoredItems.txt', 'w')
    ignoredFile.write('\n'.join(ignored))
    ignoredFile.close()
    for i in range(0, len(rawData)):
        rawData[i] = ','.join(rawData[i])
    f1 = open("extra.txt").read().split("\n")
    for i in f1:
        rawData.append(i)
    rawData = '\n'.join(rawData)
    
    f = open('items/data.txt', 'w')

    f.write(rawData)
    f.close()
    f1 = open('data.txt', 'w')
    f1.write(rawData)
    f1.close()
print("Reading xml data.")
f = open("items/data.txt").read().split("\n")

for i in range(0,len(f)):
    f[i] = f[i].split(',')
rawData = f
files = []
for i in range(0,len(rawData)):
    rawData[i][2] = rawData[i][2].replace("new","b")
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

sheets = open("sprites.txt").read().split("\n")
overrides = open("overrides.txt").read().split("\n")
bar.start()
i = 0;
for file in files:
    overriden = False
    #
    for f in overrides:
        cur = f.split(',')
        #print(file == sheet1.split(',')[0],sheet1.split(","))
        if(file in cur[0]):
                files[files.index(file)] = cur[1]
                file = cur[1]
                overriden = True
                break

    #print(files)
    if(overriden== False):
     for sheet in sheets:
         if(file in sheet):
                files[files.index(file)]=sheet
                file = sheet
                break
                
    print(file)
    response = Request('https://ae.rotf.io/sheets/'+file,headers={'User-Agent': 'Mozilla/5.0'})
    webContent = urlopen(response).read()

    f = open('raw/'+file,'wb')
    bar.update(i)
    i=i+1


    f.write(webContent)
    f.close()
bar.finish()
print("Splicing image files...")
import cv2
import numpy as np
src = cv2.imread('raw/EmbeddedAssets_lofiObj5Embed_.png', cv2.IMREAD_UNCHANGED)
src1 = cv2.imread('raw/EmbeddedAssets_lofiObj5Embed_.png')
cur = "EmbeddedAssets_lofiObj5Embed_.png"
height = src.shape[0]
width = src.shape[1]
hexNum = 16

for item in rawData:

            for i in files:
                if (item[2] in i):
                    item[2] = i
                    break
            if(cur != item[2]):
                print(cur)
                src = cv2.imread('raw/'+item[2], cv2.IMREAD_UNCHANGED)
                src1 = cv2.imread('raw/' + item[2] )
                cur = item[2]
                try:
                    height = src.shape[0]
                    width = src.shape[1]
                    itmSqr = int(width / hexNum)
                except:
                    pass

            try:

            #print(int(item[3][len(item[3])-2],16),int(item[3][len(item[3])-1],16))
                val = int(item[3],16)
                curposx = (val%16)*itmSqr
                curposy = (val//16)*itmSqr
                endposx = curposx + itmSqr
                endposy = curposy + itmSqr

                gray = src[curposy:endposy,curposx:endposx]
                img = src[curposy:endposy,curposx:endposx]
                img1 = src1[curposy:endposy,curposx:endposx]

                scale_percent = 5000  # percent of original size
                width = int(img.shape[1] * scale_percent / 100)
                height = int(img.shape[0] * scale_percent / 100)
                dim = (width, height)
                # resize image
                resized = cv2.resize(img, dim, interpolation=cv2.INTER_AREA)
                resized1 = cv2.resize(img1, dim, interpolation=cv2.INTER_AREA)

                bgr = resized[:, :, :3]  # Channels 0..2
                gray = cv2.cvtColor(bgr, cv2.COLOR_BGR2GRAY)

                thresh = 1

                ret, thresh_img = cv2.threshold(gray, thresh, 255, cv2.THRESH_BINARY)

                contours, hierarchy = cv2.findContours(thresh_img, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)

                cv2.drawContours(resized1, contours, -1, (0, 0, 0, 1), 20)
                alpha = resized[:, :, 3]  # Channel 3
                result = np.dstack([resized1, alpha])
                cv2.imwrite("items/"+item[0]+".png", result)
            except:
                print(item)



print("The whole process finished.Press enter twice to continue.")
input()
input()
