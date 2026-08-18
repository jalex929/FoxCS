coins = ('Bronze','Silver','Platinum','Gold')
for coin in coins:
    print ('You possess a', coin, 'coin.')
    if coin == 'Platinum':
        print('Congratulations! The platinum coin will move you to the next level!')
        continue
    