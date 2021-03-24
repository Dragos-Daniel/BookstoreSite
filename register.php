
<?php
require_once ('connection.php');
//Adaugare salariat
if(isset($_POST['AdaugaSal'])){
    $rep=$_POST['Reprezentanta'];
    $functie=$_POST['Functie'];
    $nume=$_POST['Nume'];
    $pren=$_POST['Prenume'];
    $cnp=$_POST['CNP'];
    $strada=$_POST['Strada'];
    $numar=$_POST['Numar'];
    $oras=$_POST['Oras'];
    $judet=$_POST['Judet'];
    $sex=$_POST['Sex'];
    $dtn=$_POST['Data_Nastere'];
    $dta=$_POST['Data_Angajare'];
    $sal=$_POST['Salariu'];
    $query="INSERT INTO Salariati(ID_Reprezentanta,Functie,Nume,Prenume,CNP,Strada,Numar,Oras,Judet,Sex,Data_Nastere,Data_Angajare,Salariu)
values ('$rep','$functie','$nume','$pren','$cnp','$strada','$numar','$oras','$judet','$sex','$dtn','$dta','$sal')";
    //echo $rep;
    $run=sqlsrv_query($conn,$query);
    //echo $functie.$nume.$pren.$cnp.$strada.$numar.$oras.$judet.$sex.$dtn.$dta.$sal;

}
if(isset($_POST['AdaugaProd'])) {
    //Adauga Produs
    $idtip = $_POST['IDTip'];
    $numeprod = $_POST['Nume_Produs'];
    $dataap = $_POST['Data_Aparitiei'];
    $nrexemp = $_POST['Nr_Exemplare'];
    $nume = $_POST['Nume'];
    $query="INSERT INTO Produs(ID_Tip,Nume_Produs,Data_Aparitiei,Nr_Exemplare)
values('$idtip','$numeprod','$dataap','$nrexemp')";
    $run=sqlsrv_query($conn,$query);

    $idautor = "SELECT ID_Salariat FROM Salariati WHERE Nume = '$nume'";
    $run=sqlsrv_query($conn,$idautor);
    $idautor = sqlsrv_fetch_array($run);

    $idprod =" SELECT ID_Produs FROM Produs WHERE Nume_Produs = '$numeprod'";
    $run=sqlsrv_query($conn,$idprod);
    $idprod = sqlsrv_fetch_array($run);

    $query ="INSERT INTO Salariat_Produs(ID_Salariat,ID_Produs) values ('$idautor[0]','$idprod[0]')";
    $run=sqlsrv_query($conn,$query);
}

if(isset($_POST['AdaugaClient'])) {
    //Adauga Client
    $nume = $_POST['Nume_Client'];
    $pren=$_POST['Prenume_Client'];
    $tip = $_POST['Tip_Client'];
    $strada = $_POST['Strada_Client'];
    $numar = $_POST['Numar_Client'];
    $oras = $_POST['Oras_Client'];
    $judet = $_POST['Judet_Client'];
    $query="INSERT INTO Client(Nume_Client,Prenume_Client,Tip_Client,Strada,Numar,Oras,Judet)
values('$nume','$pren','$tip','$strada','$numar','$oras','$judet')";
    $run=sqlsrv_query($conn,$query);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

<ul>
    <li><a href="login.php">Delogare</a></li>
    <li><a  href="index.php">Acasa</a></li>
    <li><a class="active" href="register.php">Inregistrari</a></li>
    <li><a href="comenzi.php">Adaugare Comenzi</a></li>
    <li><a href="GestAng.php">Gestionare Angajati</a></li>
    <li><a href="ExpComenzi.php">Expediere Comenzi</a></li>

</ul>
<form method="POST" action="register.php">
    <p><b>Adaugare Salariat</b></p>
    <br>
    <label for="Reprezentanta "> Reprezentanta: </label>
    <input type="text" name="Reprezentanta" required>

    <label for="Functie "> Functie ocupata: </label>
    <input type="text" name="Functie" required>

    <label for="Nume "> Nume: </label>
    <input type="text" name="Nume" required>

    <label for="Prenume"> Prenume: </label>
    <input type="text" name="Prenume" required>

    <label for="CNP"> CNP: </label>
    <input type="text" name="CNP" required>

    <label for="Strada"> Strada: </label>
    <input type="text" name="Strada" required>

    <label for="Numar"> Numar: </label>
    <input type="text" name="Numar" required>

    <label for="Oras"> Oras: </label>
    <input type="text" name="Oras" required>

    <label for="Judet"> Judet: </label>
    <input type="text" name="Judet" required>

    <label for="Sex"> Sex: </label>
    <input type="text" name="Sex" required>

    <label for="Data_Nastere"> Data Nastere: </label>
    <input type="date" name="Data_Nastere" required>

    <label for="Data_angajare"> Data Angajare </label>
    <input type="date" name="Data_Angajare" required>

    <label for="Salariu"> Salariu </label>
    <input type="text" name="Salariu" required>

    <input type="submit" value="Adauga Salariat ⇨" name="AdaugaSal">
</form>

<form method="POST" action="register.php" >
    <p><b>Adaugare Produs</b></p>
    <br>
    <label for="IDTip "> Cod tip produs: </label>
    <input type="text" name="IDTip" required>

    <label for="Nume_Produs "> Nume Produs: </label>
    <input type="text" name="Nume_Produs" required>

    <label for="Data_Aparitiei"> Data Lansare: </label>
    <input type="date" name="Data_Aparitiei" required>

    <label for="Nr_Exemplare"> Numar Exemplare: </label>
    <input type="text" name="Nr_Exemplare" required>

    <label for="Nume"> Nume autor: </label>
    <input type="text" name="Nume" required>

    <input type="submit" value="Adauga Produs ⇨" name="AdaugaProd">
</form>

<form method="POST" action="register.php" >
    <p><b>Adaugare Client</b></p>
    <br>
    <label for="Nume_Client "> Nume Client: </label>
    <input type="text" name="Nume_Client" required>

    <label for="Prenume_Client "> Prenume Client: </label>
    <input type="text" name="Prenume_Client" >

    <label for="Tip_Client "> Tipul Clientului(PFA/PJU): </label>
    <input type="text" name="Tip_Client" required>

    <label for="Strada_Client"> Strada: </label>
    <input type="text" name="Strada_Client" required>

    <label for="Numar_Client"> Numar : </label>
    <input type="text" name="Numar_Client" required>

    <label for="Oras_Client"> Oras : </label>
    <input type="text" name="Oras_Client" required>

    <label for="Judet_Client"> Judet : </label>
    <input type="text" name="Judet_Client" required>

    <input type="submit" value="Adauga Client ⇨" name="AdaugaClient">
</form>

</body>
</html>
