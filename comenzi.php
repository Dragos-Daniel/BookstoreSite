<?php
require_once ('connection.php');
if(isset($_POST['AdaugaComanda'])) {
    //ADAUGARI COMANDA
    $idclient = $_POST['ID_Client'];
    $idprodus = $_POST['ID_Produs'];
    $cant = $_POST['Cantitate'];
    $numarcmd = $_POST['Numar_Comanda'];
    $dataexp = $_POST['Data_Expediere'];
    $vstock="SELECT Nr_Exemplare FROM Produs WHERE ID_Produs = '$idprodus'";
    $run = sqlsrv_query($conn,$vstock);
    $vstock = sqlsrv_fetch_array($run);
    if($cant > $vstock) {
        echo("Comanda depaseste limita stocului pentru produsul dorit,anunta Clientul si Proceseaza alta comanda!");
    }
    else{
        $query = "INSERT INTO Produs_Client(ID_Produs,ID_Client,Cantitate_Cump,Numar_Comanda,Data_Expediere)
values ('$idprodus','$idclient','$cant','$numarcmd','$dataexp')";
        $run = sqlsrv_query($conn, $query);
        $aux = $vstock[0] - $cant;
        $query = "UPDATE Produs SET Nr_Exemplare = '$aux' WHERE ID_Produs = '$idprodus'";
        $run= sqlsrv_query($conn,$query);
        echo("Comanda procesata cu succes!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="comenzi.css">
</head>
<body>

<ul>
    <li><a href="login.php">Delogare</a></li>
    <li><a  href="index.php">Acasa</a></li>
    <li><a href="register.php">Inregistrari</a></li>
    <li><a class="active" href="comenzi.php">Adaugare Comenzi</a></li>
    <li><a href="GestAng.php">Gestionare Angajati</a></li>
    <li><a href="ExpComenzi.php">Expediere Comenzi</a></li>

</ul>

<form method="POST" action="comenzi.php">
    <p><b>Adaugare Comanda</b></p>
    <br>
    <label for="ID_Produs "> ID_Produs: </label>
    <input type="text" name="ID_Produs" required>

    <label for="ID_Client "> ID_Client: </label>
    <input type="text" name="ID_Client" required>

    <label for="Cantitate "> Cantitate: </label>
    <input type="text" name="Cantitate" required>

    <label for="Numar_Comanda"> Numar Comanda: </label>
    <input type="text" name="Numar_Comanda" required>

    <label for="Data_Expediere">Data Expediere: </label>
    <input type="date" name="Data_Expediere" required>

    <input type="submit" value="Adauga Comanda ⇨" name="AdaugaComanda">
</body>
</html>
