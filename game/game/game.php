<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

session_start();

// Preveri, ali obstaja seja z uporabniki
if (!isset($_SESSION['users'])) {
    // Če seja ne obstaja, preusmeri na prvo stran
    header('Location: index.php');
    exit;
}

// Preveri, ali obstajajo že rezultati metanja kocke
if (!isset($_SESSION['dice_results'])) {
    // Ustvari novo sejo za rezultate metanja kocke
    $_SESSION['dice_results'] = [];
}

// Preveri, ali je igra končana (vse kocke so bile vržene)
if (isset($_SESSION['dice_results']) && count($_SESSION['dice_results']) === count($_SESSION['users']) * 3) {
    // Izračunaj zmagovalce
    $users = $_SESSION['users'];
    $dice_results = $_SESSION['dice_results'];
    $user_scores = [];

    for ($i = 0; $i < count($users); $i++) {
        $user_scores[$i] = 0;

        for ($j = 0; $j < 3; $j++) {
            $result_index = $i * 3 + $j;

            if (isset($dice_results[$result_index])) {
                $dice_result = $dice_results[$result_index]['dice_result'];
                $user_scores[$i] += $dice_result;
            }
        }
    }

    // Ugotovi zmagovalce
    $max_score = max($user_scores);
    $winners = [];

    for ($i = 0; $i < count($users); $i++) {
        if ($user_scores[$i] === $max_score) {
            $winners[] = $users[$i];
        }
    }

    // Shrani zmagovalce v sejo
    $_SESSION['winners'] = $winners;

    
}

// Preveri, ali je bila pritisnjena tipka za metanje kocke
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roll_dice'])) {
    // Preveri, ali je igra še v teku
    if (count($_SESSION['dice_results']) < count($_SESSION['users']) * 3) {
        // Izvrši metanje kocke
        $user_index = floor(count($_SESSION['dice_results']) / 3);
        $dice_index = count($_SESSION['dice_results']) % 3;
        $dice_result = rand(1, 6);
        $_SESSION['dice_results'][] = [
            'user_index' => $user_index,
            'dice_index' => $dice_index,
            'dice_result' => $dice_result
        ];
        // Shrani spremembe v sejo, da se animacija izvede
        session_write_close();
        // Počakaj 1 sekundo pred preusmeritvijo na isto stran
        sleep(2);
        header('Location: game.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        *{
            margin:0;
            padding:0;
        }
        body {
            display: grid;
            place-items: center;
            
            width: 100%;
            height: 100vh;
            
            background-image: url("img/background2.jpg");
            background-position: center;
	        background-repeat: no-repeat;
	        background-size: cover;
	        background-attachment: fixed;


            font-family: Arial, sans-serif;
            
            margin: 0;
            
            
        }

        h1 {
            text-align: center;
            color: #c5241a;
            margin-bottom: 20px;
            font-size: 80px;
            text-shadow: 4px 10px 10px rgba(160,21,16,0.6);
            
        }

        table {
            

            height: 400px;
            width: 700px;


            border-collapse: collapse;
            
            max-width: 700px;
            background-color: #252d33;
            border-radius: 20px;
            border: 1px solid;
            border-color: rgba(193, 118, 51, 0.5);
            color: #fffcf1;
        
    
            font-size:15pt;
            
            
        }
        th, td {
            width: 700px;
            padding: 20px;
            text-align: center;
            
        }

        th {
            background-color: rgba(193, 118, 51, 1);
            color: #fffcf1;
            width: 700px;
            font-size:18pt;
            font-weight: bold;

        }

        tr:nth-child(even) {
            background-color: #121619;
        }

        .winners {
            font-weight: bold;
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

        #animation {
            display: none;
            text-align: center;
        }

        #skupaj{
            height: 100vh;
            width: 700px;
            display: grid;
            place-items: center;

        }

        #ces{
            position:absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            scale:80%;
        }

        #gumb, #gumb2{
            

            width: 50%;
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

        #gumb:hover, #gumb2:hover{
            background-color: rgba(243, 199, 134, 1);
            transition: 0.8s;
        }


        @keyframes scaleUp {
        0% {
        transform: scale(80%)
        }
        100% {
        transform: scale(100%);
        }
    }

        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

    </style>
    <script>
        function showAnimation() {
            

            document.getElementById('animation').style.display = 'block';
            setTimeout(function () {
                document.getElementById('animation').style.display = 'none';
            }, 3000); // Skrij animacijo po 3 sekundah
        }
    </script>
</head>
<body>
    <div id=skupi>
        <h1>Razplet igre</h1>
        <table>
            <tr>
                <th>Igralec</th>
                <th>Met 1</th>
                <th>Met 2</th>
                <th>Met 3</th>
            </tr>
            <?php
                    // Izpis rezultatov za vsakega uporabnika
                    $users = $_SESSION['users'];
                    $dice_results = $_SESSION['dice_results'];
                    $user_scores = [];
            
                    for ($i = 0; $i < count($users); $i++) {
                        $user = $users[$i];
                        $user_scores[$i] = 0;
                        ?>
                        <tr>
                            <td><?php echo $user; ?></td>
                            <?php
                            // Izpis rezultatov kock za vsakega uporabnika
                            for ($j = 0; $j < 3; $j++) {
                                $result_index = $i * 3 + $j;
                                if (isset($dice_results[$result_index])) {
                                    $dice_result = $dice_results[$result_index]['dice_result'];
                                    $user_scores[$i] += $dice_result;
                                    ?>
                                    <td><?php echo $dice_result; ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td>-</td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            
                <div class="button-container">
                    <?php
                    // Preveri, ali je igra še v teku
                    if (count($dice_results) < count($users) * 3) {
                        ?>
                        <form action="game.php" method="post" onsubmit="showAnimation()">
                            <button id="gumb" type="submit" name="roll_dice">Vrži kocko</button>
                        </form>
                        <?php
                    }
                    else {
                        ?>
                        <form action="results.php" method="post">
                            <button id="gumb2" type="submit" name="view_results">Prikaži zmagovalce</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>

            <div id="ces">    
                <div id="animation" style="display: none; text-align: center;">
                    <img src="img/dice.gif" alt="Gif animacija" />
                </div>
            </div>
        </div>
            
        </body>
        </html>
        