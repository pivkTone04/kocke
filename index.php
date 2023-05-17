<?php
// Prepreči shranjevanje v predpomnilnik brskalnika
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

// Preveri, ali obstaja seja z igralci
session_start();
if (isset($_SESSION['users'])) {
    // Če seja obstaja, jo izbriši za začetek nove igre
    session_destroy();
    $_SESSION = array();
}
?>

<?php
if (isset($_POST['submit'])) {
    // Preverjanje, ali so bila vnesena vsa polja
    if (!empty($_POST['users'][0]) && !empty($_POST['users'][1]) && !empty($_POST['users'][2])) {
        // Shrani uporabnike v sejo
        $_SESSION['users'] = $_POST['users'];

        // Preusmeri na stran z igro
        header('Location: game.php');
        exit;
    } else {
        echo 'Prosim, izpolnite vsa polja.';
    }
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
            background-image: url("img/background.png");
            background-position: center;
	        background-repeat: no-repeat;
	        background-size: cover;
	        background-attachment: fixed;
            
            
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            margin: 0;
            /*padding: 20px;*/
        }

        h1 {
            text-align: center;
            color: #c5241a;
            margin-bottom: 20px;
            font-size: 80px;
            text-shadow: 4px 10px 10px rgba(160,21,16,0.6)
        }

        

        input[type="text"] {
            width: 90%;
            padding: 20px;
            border: 1px solid;
            border-radius: 4px;
            border-color: rgba(193, 118, 51, 0.5);
            text-align: center;
            font-size: 12pt;
            background-color: rgba(91, 66, 44, 0.2);
            color: #fffcf1;
        }


        .split{
            height: 100%;
            width: 50%;
            display: flex;
            float:left;
        }
        

        #loci{
            width: 100%;
            height: 100vh;
        }

        .footer{
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;

            animation: fadeInAnimation ease 3s, slideInFromUp 2s ease-out 0s 1;
            
        }

        input[type="submit"] {
            width: 99%;
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


        input[type="submit"]:hover {
            background-color: rgba(243, 199, 134, 1);
            transition: 0.8s;
        }

        form {
            display: grid;
            place-items: center;
            
            margin: 0 auto;
            width: 60%;
            height: 400px;
            max-width: 500px;
            background-color: #121619;
            padding: 40px;
            border: 1px solid;
            border-radius: 5px;
            
            border-color: rgba(193, 118, 51, 0.5);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            color: #f3c786;
            display: block;
            margin-top: 20px;
            
            font-weight: bold;
            text-align: center;

            font-size: 13pt;
        }

        .help{
            width: 100%;
            height: 600px;
        }


    @keyframes slideInFromUp {
        0% {
        transform: translateY(-20%);
        }
        100% {
        transform: translateY(0);
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
</head>
<body>
    <div id="loci">
        <div class="split left"></div>
        <div class="split right">
            <div class=footer>
                <div class=help>
                    <h1>KOCKANJE</h1>
                    <form action="index.php" method="post">
                        <label for="user1">Igralec 1:</label>
                        <input maxlength="18" type="text" id="user1" name="users[0]" placeholder="ime igralca" required>

                        <label for="user2">Igralec 2:</label>
                        <input maxlength="18" type="text" id="user2" name="users[1]" placeholder="ime igralca" required>

                        <label for="user3">Igralec 3:</label>
                        <input maxlength="18" type="text" id="user3" name="users[2]" placeholder="ime igralca" required>

                    <input type="submit" name="submit" value="Začni igro">
                </form>
                </div>
            </div>
        </div>
    <div>
</body>
</html>

