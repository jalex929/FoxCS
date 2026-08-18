import os

print("Your current directory is:", os.getcwd())

for text_file in os.listdir():
    if text_file.endswith('.txt'):
        print(text_file)



