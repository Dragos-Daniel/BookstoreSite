<!--Proces LOGIN-->
<?php
require_once ('connection.php');
?>
<html>
<head>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<?php
if(isset($_POST['Login'])){
    $User=$_POST['User'];
    $Pass=$_POST['Parola'];
    $query="SELECT * FROM ADMIN WHERE Utilizator='$User'";
    $run=sqlsrv_query($conn,$query);
    $rez=sqlsrv_fetch_array($run);
    if($rez!='') {
        $_SESSION["Conectat"] = 1;
        header("Location: http://localhost/Proiect%20BD/index.php");
    }
    else{
        echo("Utilizator sau parola gresit, te rugam verifica datele introduse");
    }


}

?>

<div class="container">
    <div class="left">
        <div class="header">
            <h2 class="animation a1">Bine ai venit!</h2>
            <h4 class="animation a2">Logheaza-te folosind contul tau de administrator</h4>
        </div>

                <form method="POST" action="login.php">
                <label for="User">User:</label>
                <input type="text" class="form-field animation a3" name="User" placeholder="Introdu User*" required>
                <label for="Parola">Parola:</label>
                <input type="text"  class="form-field animation a4" name="Parola" placeholder="Introdu Parola*" required>
                <input type="submit" value="Trimite" name="Login">
            </form>

    </div>
    <div class="right"></div>
</div>


</body>
</html>


