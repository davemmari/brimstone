<?php
require_once 'hero.php';
$heroObj = new Hero();

$heroId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$hero = $heroObj->getHeroById($heroId);

if (!$hero) { header("Location: load_game.php"); exit; }

$heroImage = strtolower($hero['role']) . ".png";
$message = "Hati-hati, ada monster!";

if ($hero['hp'] <= 0) {
    $message = "Rest in peace my " . $hero['name'] . " he/she got hit by a bazooka...";
    $message = "[KARAKTER ANDA SUDAH MATI. SILAHKAN BUAT KARAKTER BARU ATAU PILIH KARAKTER LAIN]";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionBtn']) && $hero['hp'] > 0) {
    $action = $_POST['actionBtn'];
    $currentHp = $hero['hp'];
    $currentGold = $hero['gold'];

    if ($action == 'attack') {
        $heroDmg = $hero['atk']; 
        $monsterDmg = 25 - ($hero['def']);
        $loot = rand(5, 25);

        $currentHp = max(0, $currentHp - $monsterDmg);
        $currentGold += $loot;
        
        if ($currentHp <= 0) {
            $message = "Rest in peace my " . $hero['name'] . " he/she got hit by a bazooka...";
        } else {
            $message = "UHUK! Kena serang $monsterDmg dmg. Tapi tenang, anda berhasil membalas dengan $heroDmg dmg. Anda dapat $loot G.";
        }
    } elseif ($action == 'heal') {
        if ($currentGold >= 25) {
            $currentHp = min($hero['max_hp'], $currentHp + 20);
            $currentGold -= 25;
            $message = "ALKOHOL APA INI?! [+20 HP]";
        } else {
            $message = "Cieee, belum gajian yaaa. [BUTUH 25G UNTUK HEAL]";
        }
    }
    
    $heroObj->updateStats($heroId, $currentHp, $currentGold);
    $hero = $heroObj->getHeroById($heroId);
}

$hpPercent = ($hero['hp'] / $hero['max_hp']) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Battle - <?= htmlspecialchars($hero['name']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px; padding: 20px;">
        
        <div class="arena-header">
            <div>
                <div style="font-family: 'Press Start 2P', cursive; font-size: 14px; color: #fff; margin-bottom: 5px;">
                    <?= htmlspecialchars($hero['name']) ?> <span style="color: var(--text-muted); font-size: 10px;">[<?= strtoupper($hero['role']) ?>]</span>
                </div>
                <div style="color: var(--primary); font-size: 20px;"><?= $hero['gold'] ?> G</div>
            </div>
            <a href="load_game.php" class="btn" style="border-color: var(--text-muted); padding: 10px 15px; font-size: 10px;">CABUT</a>
        </div>

        <div class="battle-stage">
            <div class="combatant">
                <img src="assets/<?= $heroImage ?>" alt="Hero">
                <div class="hp-bar-bg">
                    <div class="hp-bar-fill" style="width: <?= $hpPercent ?>%;"></div>
                </div>
                <div class="hp-text"><?= $hero['hp'] ?> / <?= $hero['max_hp'] ?></div>
            </div>
            
            <div class="combatant monster">
                <img src="assets/monster.png" alt="Monster">
                <div class="hp-bar-bg">
                    <div class="hp-bar-fill" style="width: 100%; background: #d000ff;"></div>
                </div>
                <div class="hp-text">??? / ???</div>
            </div>
        </div>

        <!-- DIALOG BOX -->
        <div class="dialog-box">
            <?= htmlspecialchars($message) ?>
        </div>

        <!-- ACTION MENU -->
        <?php if($hero['hp'] > 0): ?>
        <form method="POST" action="" class="action-menu">
            <button type="submit" name="actionBtn" value="attack" class="btn btn-danger" style="flex: 1;">ATTACK</button>
            <button type="submit" name="actionBtn" value="heal" class="btn btn-success" style="flex: 1;">HEAL (25G)</button>
        </form>
        <?php else: ?>
        <div class="action-menu">
            <a href="load_game.php" class="btn btn-primary" style="flex: 1;">RETURN KE MENU</a>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>