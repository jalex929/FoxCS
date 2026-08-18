

items = ['Wand', 'Rock', 'Pogo Stick']
levels = [1, 2, 3]
for level in levels:
    for item in items:
        if level == 2 and item == 'Rock':
            continue
        else:
            print(f"You can get a {item} at level {level}.")
