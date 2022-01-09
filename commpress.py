# 圧縮 ファイル名そのまま
# 2x(圧縮)　ファイル名@2x.ex
# webp　ファイル名.webp
# 2x(webp)　ファイル名@2x.webp
import sys,os
from PIL import Image, ImageFilter
filename = sys.argv[1]
real_filename = sys.argv[2]
aFile = os.path.splitext(os.path.basename(real_filename))
os.makedirs(aFile[0] + '/webp')
# print(aFile)
# print(filename)
image = Image.open(filename)
# print(image.size)
def compress(image):
    width = image.size[0]
    height = image.size[1]
    resize_img = image.resize((width, height), Image.LANCZOS) 
    resize_img.save(aFile[0] + '/' + aFile[0] + aFile[1])

compress(image)
def compress2x(image):
    width = image.size[0]
    height = image.size[1]
    resize_img = image.resize((width * 2, height * 2), Image.LANCZOS) 
    resize_img.save(aFile[0] + '/' + aFile[0] + '@2x' +aFile[1])

compress2x(image)
def compressWebp(image):
    width = image.size[0]
    height = image.size[1]
    resize_img = image.resize((width, height), Image.LANCZOS) 
    resize_img.save(aFile[0] + '/webp/' + aFile[0] +'.webp')

compressWebp(image)
def compressWebp2x(image):
    width = image.size[0]
    height = image.size[1]
    resize_img = image.resize((width * 2, height * 2), Image.LANCZOS) 
    resize_img.save(aFile[0] + '/webp/' + aFile[0] +'@2x.webp')

compressWebp2x(image)