<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

session_start();

// Preveri, ali so zmagovalci shranjeni v seji
if (isset($_SESSION['winners'])) {
    $winners = $_SESSION['winners'];
} else {
    // Če zmagovalci niso shranjeni, preusmeri nazaj na game.php
    header('Location: game.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kockanje</title>
    <link rel="icon" type="image/x-icon" href="img/favico.png">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        
        body {
            background-image: url("img/background3.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            

            height: 100vh;
            width: 100%;

            display: grid;
            place-items: center;

            color: white;
            font-size: 20pt;
        }

        h1 {
            text-align: center;
            color: #c5241a;
            margin-bottom: 20px;
            font-size: 80px;
            text-shadow: 4px 10px 10px rgba(160,21,16,0.6);
            text-align: center;
        }

        .winners {
            text-align: center;
            
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .skupi{
            height:400px;
            width:100%;
            display: grid;
            place-items: center;
        }

        #gumb{
            width: 200px;
            padding: 20px;
            margin-top: 20px;
            background-color: rgba(243, 199, 134, 0.6);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            position: center;
            font-size: 12pt;
            font-weight: bold;

            transition: 1s;
        }

        #gumb:hover{
            background-color: rgba(243, 199, 134, 1);
            transition: 0.8s;
        }

        .majse_crke.p{
            font-size: 10px;
        }
        .cez{
            position: absolute;
            width: 100%;
            height: 100%;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
        }

        .zmagovalci{
            
             background-image: linear-gradient(45deg, #ffd650, #d59c45);
            background-clip: text;
            font-size: 70px;
            -webkit-text-fill-color: transparent;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent; 
            -moz-background-clip: text;
            -moz-text-fill-color: transparent;
            text-shadow: 4px 10px 10px rgba(213,156,69,0.6);

            animation: fadeInAnimation ease 6s, slideInFromUp 4s ease-out 0s 4;
        }

        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideInFromUp {
        0% {
        transform: translateY(-60%);
        }
        100% {
        transform: translateY(0);
        }
    }
    </style>
    <script>
        var countdown = 10;

        function startCountdown() {
            var countdownElement = document.getElementById("countdown");
            if (countdown > 0) {
                countdown--;
                countdownElement.textContent = "Preusmerjenje čez " + countdown + " sekund.";
                setTimeout(startCountdown, 1000);
            } else {
                window.location.href = "index.php";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            startCountdown();
        });
    </script>
</head>
<body>
    <div class="skupi">
        <h1>Zmagovalci igre</h1>
        <div class="winners">
         <?php
            if (isset($_SESSION['winners'])) {
                $winners = $_SESSION['winners'];
                if (count($winners) === 1) {
                    echo "<p>Čestitamo, naslednji uporabnik je zmagovalec:</p>";
                    echo "<br>";
                    ?>
                    <div class="zmagovalci">
                        <?php
                        echo "<b>{$winners[0]}</b>";
                        ?>
                    </div>
                    <?php

                } else {
                    echo "<p>Čestitamo, naslednji uporabniki so zmagovalci:</p>";
                    echo "<br>";
                    foreach ($winners as $winner) {
                        echo "<b>{$winner}</b><br>";
                    }
                }
            } else {
                echo "<p>Ni zmagovalcev.</p>";
            }
        ?>
        </div>

        <div class="button-container">
            
            <br>
            <p class="majse crke"> <span id="countdown">10 sekund</span>.</p>
        </div>

        <div class="cez">
            <img src="img/firework.gif" alt="Gif animacija" />
        </div>
    </div>
</body>
</html>

