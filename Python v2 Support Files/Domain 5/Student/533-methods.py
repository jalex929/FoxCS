class Game_Player:
    def __init__(character,score):
        character.name = character
        character.score = 0
    def get_score(character, interval=10):
        character.score += interval
        return character.score
    
game_player1 = Game_Player("Robin")
print(game_player1.get_score()) #should be 10
print(game_player1.get_score(100)) #should be 110
