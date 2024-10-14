<?php
$diceFaces = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];

function rollDice() {
    return array_map(function() {
        return rand(1, 6);
    }, range(1, 5));
}

function calculateScore($rolls) {
    sort($rolls);
    return array_sum(array_slice($rolls, 1, -1));
}

$player1 = $player2 = $winner = null;

if (isset($_POST['play'])) {
    $player1Rolls = rollDice();
    $player2Rolls = rollDice();
    $player1Score = calculateScore($player1Rolls);
    $player2Score = calculateScore($player2Rolls);

    $player1 = ['rolls' => $player1Rolls, 'score' => $player1Score];
    $player2 = ['rolls' => $player2Rolls, 'score' => $player2Score];

    if ($player1Score > $player2Score) {
        $winner = 'Jugador 1';
    } elseif ($player2Score > $player1Score) {
        $winner = 'Jugador 2';
    } else {
        $winner = 'Empate';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Dados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="App">
        <h1>Cinco Dados</h1>
        
        <form method="post">
            <button type="submit" name="play">Jugar</button>
        </form>
        
        <?php if ($player1 && $player2): ?>
            <div class="results">
                <h2>Resultados</h2>
                <div class="player-container">
                    <div class="player-name">Jugador 1</div>
                    <div class="player player1">
                        <div class="dice-roll">
                            <?php foreach ($player1['rolls'] as $roll): ?>
                                <span class="dice"><?php echo $diceFaces[$roll - 1]; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="player-score">Puntuación: <?php echo $player1['score']; ?></div>
                </div>
                <div class="player-container">
                    <div class="player-name">Jugador 2</div>
                    <div class="player player2">
                        <div class="dice-roll">
                            <?php foreach ($player2['rolls'] as $roll): ?>
                                <span class="dice"><?php echo $diceFaces[$roll - 1]; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="player-score">Puntuación: <?php echo $player2['score']; ?></div>
                </div>
                <h3>Resultado: <?php echo $winner === 'Empate' ? 'Empate' : "Ha ganado el $winner"; ?></h3>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>