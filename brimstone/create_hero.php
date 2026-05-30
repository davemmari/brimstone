<?php
require_once 'hero.php';
$heroObject = new Hero();
$errorMessage = "";

if (isset($_POST['createBtn'])) {
    $heroName = $_POST['heroName'];
    $heroRole = isset($_POST['heroRole']) ? $_POST['heroRole'] : '';

    $validationResult = $heroObject->validateName($heroName);

    if ($validationResult !== "VALID") {
        $errorMessage = $validationResult;
    } elseif (empty($heroRole)) {
        $errorMessage = "CLASSNYA BELUM OI!";
    } else {
        $heroObject->createHero($heroName, $heroRole);
        header("Location: load_game.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Character</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        input[type="radio"] { display: none; }

        .hero-selection-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 25px;
        }

        .preview-screen {
            background: #00000099;
            border: 1px solid #334155;
            border-radius: 8px;
            min-height: 250px;
            padding: 20px;
            position: relative;
            overflow: hidden; 
            display: flex;
        }

        .preview-panel {
            display: none;
            width: 100%;
            height: 100%;
        }

        .preview-content {
            display: flex;
            gap: 25px;
            width: 100%;
            animation: fadeInRight 0.4s ease forwards;
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .portrait-container {
            width: 140px; 
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: flex-end; 
            border-radius: 6px;
            background: linear-gradient(to top, #eab30833, transparent);
            overflow: hidden;
        }

        .portrait-container img {
            width: 100%;
            height: 250px; 
            object-fit: cover;
            object-position: top; 
            filter: drop-shadow(0 0 10px #000000cc);
        }

        .info-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .p-title { font-size: 28px; font-weight: bold; color: var(--primary); margin-bottom: 10px; letter-spacing: 2px;}
        .p-stats { display: flex; flex-wrap: wrap; gap: 15px; font-size: 14px; margin-bottom: 15px; border-bottom: 1px dashed #334155; padding-bottom: 15px;}
        
        .val-hp {color: #4ade80; font-weight: bold;}
        .val-atk {color: #ff8000; font-weight: bold;}
        .val-spd {color: #f8fc84; font-weight: bold;} 
        .val-def {color: #8c00ff; font-weight: bold;}
        .stat-plus {color: #008cff; font-weight: bold;}
        .stat-minus {color: #ff0000; font-weight: bold;}
        .stat-norm {color: #ffffff; font-weight: bold;}
        .p-desc {font-size: 14px; line-height: 1.6; color: #cbd5e1; text-align: justify;}

        .selection-row {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .select-box {
            flex: 1; 
            background: #00000066;
            border: 2px solid #334155;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #94a3b8;
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .select-box .thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #1e293b;
            transition: all 0.3s ease;
        }

        .select-box .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            object-position: top; 
            filter: grayscale(100%) brightness(0.6);
            transition: all 0.3s ease;
        }

        .select-box:hover {
            border-color: #64748b;
            background: #ffffff0d;
            color: #fff;
        }
        .select-box:hover .thumbnail img {
            filter: grayscale(50%) brightness(0.9);
        }

        #role_warrior:checked ~ .preview-screen #panel_warrior,
        #role_mage:checked ~ .preview-screen #panel_mage,
        #role_tank:checked ~ .preview-screen #panel_tank,
        #role_marksman:checked ~ .preview-screen #panel_marksman {
            display: block;
        }

        #role_warrior:checked ~ .selection-row label[for="role_warrior"],
        #role_mage:checked ~ .selection-row label[for="role_mage"],
        #role_tank:checked ~ .selection-row label[for="role_tank"],
        #role_marksman:checked ~ .selection-row label[for="role_marksman"] {
            border-color: var(--primary);
            color: var(--primary);
            background: #000000cc;
            transform: translateY(-4px); 
        }

        /* Thmbnail */
        #role_warrior:checked ~ .selection-row label[for="role_warrior"] .thumbnail img,
        #role_mage:checked ~ .selection-row label[for="role_mage"] .thumbnail img,
        #role_tank:checked ~ .selection-row label[for="role_tank"] .thumbnail img,
        #role_marksman:checked ~ .selection-row label[for="role_marksman"] .thumbnail img {
            filter: grayscale(0%) brightness(1.2);
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 750px;">
        <h2>CREATE NEW HERO</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="error-msg"> <?= $errorMessage ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="heroName" placeholder="ENTER HERO NAME" autocomplete="off" value="<?= isset($_POST['heroName']) ? htmlspecialchars($_POST['heroName']) : '' ?>" style="margin-bottom: 0;">

            <div class="hero-selection-layout">
                
                <input type="radio" name="heroRole" id="role_warrior" value="Warrior" checked>
                <input type="radio" name="heroRole" id="role_mage" value="Mage">
                <input type="radio" name="heroRole" id="role_tank" value="Tank">
                <input type="radio" name="heroRole" id="role_marksman" value="Marksman">

                <!-- PREVIEW -->
                <div class="preview-screen">
                    
                    <!-- WARRIOR -->
                    <div class="preview-panel" id="panel_warrior">
                        <div class="preview-content">
                            <div class="portrait-container">
                                <img src="assets/warrior.png" alt="Warrior">
                            </div>
                            <div class="info-container">
                                <div class="p-title">WARRIOR</div>
                                <div class="p-stats">
                                    <div class="val-hp">HP <span class="stat-norm">●</span></div>
                                    <div class="val-atk">ATK <span class="stat-norm">●</span></div>
                                    <div class="val-spd">SPD <span class="stat-norm">●</span></div>
                                    <div class="val-def">DEF <span class="stat-plus">+</span></div>
                                </div>
                                <div class="p-desc">Ahli pedang pokoknya. Dibanding yang lain, dia yang paling normal. Simplenya balance out.</div>
                            </div>
                        </div>
                    </div>

                    <!-- MAGE -->
                    <div class="preview-panel" id="panel_mage">
                        <div class="preview-content">
                            <div class="portrait-container">
                                <img src="assets/mage.png" alt="Mage">
                            </div>
                            <div class="info-container">
                                <div class="p-title">MAGE</div>
                                <div class="p-stats">
                                    <div class="val-hp">HP <span class="stat-minus">-</span></div>
                                    <div class="val-atk">ATK <span class="stat-plus">++</span></div>
                                    <div class="val-spd">SPD <span class="stat-norm">●</span></div>
                                    <div class="val-def">DEF <span class="stat-minus">-</span></div>
                                </div>
                                <div class="p-desc">"Frieren" ahh, "Fireball" ahh. Basically Attack bagus, tapi HP sama Defence kurang.</div>
                            </div>
                        </div>
                    </div>

                    <!-- TANK -->
                    <div class="preview-panel" id="panel_tank">
                        <div class="preview-content">
                            <div class="portrait-container">
                                <img src="assets/tank.png" alt="Tank">
                            </div>
                            <div class="info-container">
                                <div class="p-title">TANK</div>
                                <div class="p-stats">
                                    <div class="val-hp">HP <span class="stat-plus">++</span></div>
                                    <div class="val-atk">ATK <span class="stat-minus">--</span></div>
                                    <div class="val-spd">SPD <span class="stat-minus">-</span></div>
                                    <div class="val-def">DEF <span class="stat-plus">++</span></div>
                                </div>
                                <div class="p-desc">Benteng berjalan. HP sama Defence GGWP, Attack sama Speed kureng banget.</div>
                            </div>
                        </div>
                    </div>

                    <!-- MM -->
                    <div class="preview-panel" id="panel_marksman">
                        <div class="preview-content">
                            <div class="portrait-container">
                                <img src="assets/marksman.png" alt="Marksman">
                            </div>
                            <div class="info-container">
                                <div class="p-title">MARKSMAN</div>
                                <div class="p-stats">
                                    <div class="val-hp">HP <span class="stat-minus">--</span></div>
                                    <div class="val-atk">ATK <span class="stat-plus">+</span></div>
                                    <div class="val-spd">SPD <span class="stat-plus">++</span></div>
                                    <div class="val-def">DEF <span class="stat-minus">-</span></div>
                                </div>
                                <div class="p-desc">MM pada umumnya lah ya. Attack ok, Speed W banget, tapi basically "Glass Cannon".</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="selection-row">
                    <label for="role_warrior" class="select-box">
                        <div class="thumbnail"><img src="assets/warrior.png" alt="W"></div>
                        <span>WARRIOR</span>
                    </label>
                    <label for="role_mage" class="select-box">
                        <div class="thumbnail"><img src="assets/mage.png" alt="Mg"></div>
                        <span>MAGE</span>
                    </label>
                    <label for="role_tank" class="select-box">
                        <div class="thumbnail"><img src="assets/tank.png" alt="T"></div>
                        <span>TANK</span>
                    </label>
                    <label for="role_marksman" class="select-box">
                        <div class="thumbnail"><img src="assets/marksman.png" alt="Mm"></div>
                        <span>MARKSMAN</span>
                    </label>
                </div>
            </div>
            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                <a href="load_game.php" class="btn" style="border-color: var(--text-muted);">CANCEL</a>
                <button type="submit" name="createBtn" class="btn btn-primary" style="width: 60%; font-size: 18px; letter-spacing: 2px;">ARISE!!!</button>
            </div>
        </form>
    </div>
</body>
</html>