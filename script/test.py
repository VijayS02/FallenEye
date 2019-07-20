import numpy as np
import cv2
img = cv2.imread('Wand of Recompense.png', cv2.IMREAD_UNCHANGED)
img1 = cv2.imread('Wand of Recompense.png')


scale_percent = 5000 # percent of original size
width = int(img.shape[1] * scale_percent / 100)
height = int(img.shape[0] * scale_percent / 100)
dim = (width, height)
# resize image
resized = cv2.resize(img, dim, interpolation = cv2.INTER_AREA)
resized1 = cv2.resize(img1, dim, interpolation = cv2.INTER_AREA)
cv2.imwrite('text.png',resized)


bgr = resized[:,:,:3] # Channels 0..2
gray = cv2.cvtColor(bgr, cv2.COLOR_BGR2GRAY)

thresh = 1

ret,thresh_img = cv2.threshold(gray, thresh, 255, cv2.THRESH_BINARY)

contours, hierarchy = cv2.findContours(thresh_img, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)


cv2.drawContours(resized1, contours, -1, (0,255,0,1), 3)
alpha = resized[:,:,3] # Channel 3
result = np.dstack([resized1, alpha])
cv2.imwrite('contours.png',result)

cv2.waitKey(0)
cv2.destroyAllWindows()
