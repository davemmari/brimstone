<?php
require_once 'hero.php';
$heroObject = new Hero();

if (isset($_GET['deleteId'])) {
    $heroObject->deleteHero((int)$_GET['deleteId']);
    header("Location: load_game.php");
    exit;
}

$allHeroes = $heroObject->getAllHeroes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Save File</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h2>CHOOSE YOUR CHARACTER</h2>

        <div style="margin-bottom: 30px;">
            <a href="create_hero.php" class="btn btn-primary" style="display: block; width: 100%; padding: 20px; font-size: 16px;">
                CREATE NEW CHARACTER
            </a>
        </div>

        <!-- LIST FILE SAVE-AN -->
        <div style="background: #0000004d; border: 1px solid #334155; border-radius: 8px; padding: 20px;">
            <h3 style="text-align: left; font-size: 14px; margin-bottom: 20px; color: var(--text-muted);">SAVED FILES</h3>
            
            <?php if ($allHeroes->num_rows > 0): ?>
                <table class="save-table">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>CLASS</th>
                            <th>STATS</th>
                            <th style="text-align: right;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($hero = $allHeroes->fetch_assoc()): ?>
                        <tr>
                            <td style="font-size: 24px; color: #fff;"><?= htmlspecialchars($hero['name']) ?></td>
                            <td><span class="badge"><?= htmlspecialchars($hero['role']) ?></span></td>
                            <td style="color: var(--text-muted); font-size: 14px;">
                                HP: <?= $hero['hp'] ?>/<?= $hero['max_hp'] ?> <br>
                                Gold: <span style="color: var(--primary);"><?= $hero['gold'] ?>G</span>
                            </td>
                            <td style="text-align: right;">
                                <a href="play.php?id=<?= $hero['id'] ?>" class="btn btn-success" style="padding: 10px 15px; font-size: 10px;">PLAY</a>
                                <a href="load_game.php?deleteId=<?= $hero['id'] ?>" class="btn btn-danger" style="padding: 10px 15px; font-size: 10px;" onclick="return confirm('Hapus karakter ini selamanya?')">DEL</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
                    <p>[DAWG, ANDA BELOM PUNYA KARAKTER]</p>
                    <p style="font-size: 14px; margin-top: 10px;">Klik tombol [CREATE NEW CHARACTER] di atas.</p>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="index.php" class="btn" style="border-color: var(--text-muted);">KEMBALI KE [TITLE CARD]</a>
        </div>
    </div>
</body>
</html>