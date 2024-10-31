<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wintersport Aanbevelingen</title>
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/style.css'; ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo plugin_dir_url(__FILE__) . '../assets/script.js'; ?>"></script>
</head>

<body>
    <div class="form-container">
        <?php if (!empty($aanbevolen_gebied_naam)): ?>
            <h2>Aanbevolen Skigebied</h2>
            <div class="antwoord-container">
                <div class="aanbeveling-balkje"><?php echo htmlspecialchars($aanbevolen_gebied_naam); ?></div>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="restart">
                <button type="submit" class="restart-button">Start Opnieuw</button>
            </form>
        <?php else: ?>
            <h2>Wintersport Aanbeveling Vragenlijst</h2>
            <form id="survey-form" method="POST">
                <p><?php echo htmlspecialchars($vragen[$vraag_nummer]); ?></p>
                <?php foreach ($antwoorden[$vraag_nummer] as $index => $antwoord): ?>
                    <div class="answer-option" data-index="<?php echo $index; ?>">
                        <input type="radio" name="antwoord" value="<?php echo htmlspecialchars($antwoord); ?>" id="option-<?php echo $index; ?>" required>
                        <label for="option-<?php echo $index; ?>"><?php echo htmlspecialchars($antwoord); ?></label>
                    </div>
                <?php endforeach; ?>
                <input type="hidden" name="vraag_nummer" value="<?php echo $vraag_nummer; ?>">
                <input type="hidden" name="antwoorden" value="<?php echo htmlspecialchars(json_encode($antwoorden_sessie)); ?>">
                <input type="hidden" name="antwoord_index" id="antwoord_index" value="">
                <button type="submit" class="next-button">Volgende</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>