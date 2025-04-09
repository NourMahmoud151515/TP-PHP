<?php
class AttackPokemon {
    public int $attackMinimal;
    public int $attackMaximal;
    public float $specialAttack;
    public int $probabilitySpecialAttack;

    public function __construct($min, $max, $special, $probability) {
        $this->attackMinimal = $min;
        $this->attackMaximal = $max;
        $this->specialAttack = $special;
        $this->probabilitySpecialAttack = $probability;
    }

    public function getAttackPoints(): int {
        return rand($this->attackMinimal, $this->attackMaximal);
    }
}

class Pokemon {
    protected string $name;
    protected string $imageUrl;
    protected int $hp;
    protected AttackPokemon $attackPokemon;

    public function __construct($name, $imageUrl, $hp, AttackPokemon $attackPokemon) {
        $this->name = $name;
        $this->imageUrl = $imageUrl;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
    }

    public function getName(): string {
        return $this->name;
    }
    public function getImageUrl(): string {
        return $this->imageUrl;
    }
    public function getHp(): int {
        return $this->hp;
    }
    public function setHp(int $hp) {
        $this->hp = max(0, $hp);
    }
    public function isDead(): bool {
        return $this->hp <= 0;
    }

    public function attack(Pokemon $opponent) {
        $attackPoints = $this->attackPokemon->getAttackPoints();
        $specialAttackUsed = (rand(1, 100) <= $this->attackPokemon->probabilitySpecialAttack);
        if ($specialAttackUsed) {
            $attackPoints *= $this->attackPokemon->specialAttack;
        }
        $opponent->setHp($opponent->getHp() - $attackPoints);
        return $attackPoints;
    }

    public function displayInfo() {
        echo "<div style='border:1px solid black; padding:10px; text-align:center; width:40%; background:white;'>";
        echo "<h3>{$this->name}</h3>";
        echo "<img src='{$this->imageUrl}' width='120'><br>";
        echo "Points : {$this->hp}<br>";
        echo "Min Attack Points : {$this->attackPokemon->attackMinimal}<br>";
        echo "Max Attack Points : {$this->attackPokemon->attackMaximal}<br>";
        echo "Special Attack : x{$this->attackPokemon->specialAttack}<br>";
        echo "Probability Special Attack : {$this->attackPokemon->probabilitySpecialAttack}%";
        echo "</div>";
    }
}

class PokemonFeu extends Pokemon {
    public function attack(Pokemon $opponent) {
        $damage = parent::attack($opponent);
        if ($opponent instanceof PokemonPlante) {
            $damage *= 2;
        } elseif ($opponent instanceof PokemonEau) {
            $damage *= 0.5;
        }
        $opponent->setHp($opponent->getHp() - $damage);
        return $damage;
    }
}

class PokemonEau extends Pokemon {
    public function attack(Pokemon $opponent) {
        $damage = parent::attack($opponent);
        if ($opponent instanceof PokemonFeu) {
            $damage *= 2;
        } elseif ($opponent instanceof PokemonPlante) {
            $damage *= 0.5;
        }
        $opponent->setHp($opponent->getHp() - $damage);
        return $damage;
    }
}

class PokemonPlante extends Pokemon {
    public function attack(Pokemon $opponent) {
        $damage = parent::attack($opponent);
        if ($opponent instanceof PokemonEau) {
            $damage *= 2;
        } elseif ($opponent instanceof PokemonFeu) {
            $damage *= 0.5;
        }
        $opponent->setHp($opponent->getHp() - $damage);
        return $damage;
    }
}

$Charmeleon = new PokemonFeu("Charmeleon", "https://pngimg.com/uploads/pokemon/pokemon_PNG125.png", 100, new AttackPokemon(10, 20, 2, 30));
$Bulbasaur = new PokemonPlante("Bulbasaur", "https://pngimg.com/uploads/pokemon/pokemon_PNG52.png", 120, new AttackPokemon(8, 18, 2.5, 25));

$round = 1;
echo "<div style='width:80%; margin:auto; text-align:center; font-family:Arial;'>";

while (!$Charmeleon->isDead() && !$Bulbasaur->isDead()) {
    echo "<div style='display:flex; justify-content:space-around; align-items:center; margin-top:20px;'>";
    $Charmeleon->displayInfo();
    $Bulbasaur->displayInfo();
    echo "</div>";

    $damage1 = $Charmeleon->attack($Bulbasaur);
    $damage2 = $Bulbasaur->attack($Charmeleon);

    $roundColor = ($damage1 > $damage2) ? "#d4edda" : "#f8d7da";
    echo "<div style='background:$roundColor; padding:10px; margin:5px; font-weight:bold;'>Round $round | Dégâts : $damage1 - $damage2</div>";

    $round++;
}

$winner = $Charmeleon->getHp() > 0 ? $Charmeleon : $Bulbasaur;
echo "<div style='background:#d4edda; padding:15px; margin:10px; font-weight:bold; font-size:18px;'>";
echo "Le vainqueur est <img src='{$winner->getImageUrl()}' width='50'> {$winner->getName()}";
echo "</div>";

echo "</div>";
?>