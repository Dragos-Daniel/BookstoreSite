
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="GestAng.css">
</head>
<body>

<ul>
    <li><a href="login.php">Delogare</a></li>
    <li><a  href="index.php">Acasa</a></li>
    <li><a  href="register.php">Inregistrari</a></li>
    <li><a href="comenzi.php">Adaugare Comenzi</a></li>
    <li><a class="active" href="GestAng.php">Gestionare Angajati</a></li>
    <li><a href="ExpComenzi.php">Expediere Comenzi</a></li>

</ul>
<p> Situatie Angajati </p>
<div>
<?php
//Tabel cu angajati
require_once ('connection.php');
$query ="SELECT A.ID_Salariat, A.ID_Reprezentanta,A.Nume,A.Prenume,A.Functie,A.Salariu,COUNT(B.ID_Produs) as Produse FROM Salariati A LEFT JOIN Salariat_Produs B ON A.ID_Salariat= B.ID_Salariat GROUP BY  A.ID_Salariat, A.ID_Reprezentanta,A.Nume,A.Prenume,A.Functie,A.Salariu";
$run=sqlsrv_query($conn,$query);
echo "<table >
<tr>
<th>Nume</th>
<th>Prenume</th>
<th>Functie ocupata</th>
<th>Salariu</th>
<th>Nr de produse contribuite</th>
</tr>";

while($row = sqlsrv_fetch_array($run))

{
    echo "<tr>";
    echo "<td>" . $row['Nume'] . "</td>";
    echo "<td>" . $row['Prenume'] . "</td>";
    echo "<td>" . $row['Functie'] . "</td>";
    echo "<td>" . $row['Salariu'] . "</td>";
    echo "<td>" . $row['Produse'] . "</td>";
    echo "</tr>";
}
echo "</table>";

if(isset($_POST['CresteSalariu']))
//Secventa de crestere a salariului cu 10%
{
    $sal=$_POST['Salariu'];
    $prod=$_POST['ProduseSal'];
    $query = "UPDATE Salariati  SET Salariu = 1.1*Salariu WHERE Salariu <= '$sal' AND '$prod' <= (SELECT COUNT(B.ID_Produs) From Salariat_Produs B WHERE ID_Salariat = B.ID_Salariat)";
    $run = sqlsrv_query($conn,$query);

}

if(isset($_POST['Concediaza']))
//Secventa de concediere a angajatilor care nu lucreaza la nici un proiect
{
    $query = "DELETE FROM Salariati WHERE ID_Salariat NOT IN (SELECT B.ID_Salariat From Salariat_Produs B WHERE ID_Salariat = B.ID_Salariat)";
    $run = sqlsrv_query($conn,$query);

}
?>
<div>
    <form method = POST action = "GestAng.php">
        Cresteti salariul cu 10% pentru angajatii care au salariu mai mic decat:
        <label for="Salariu ">  </label>
        <input type="text" name="Salariu" required>
        si numar de produse manufacturate mai mare ca :
        <label for="Produse ">  </label>
        <input type="text" name="ProduseSal" required>
        <input type="submit" value="Creste ⇨" name="CresteSalariu">
    </form>

    <form method = POST action = "GestAng.php">
        Concediati angajatii care nu lucreaza la nici un produs.
        <input type="submit" value="Concediaza ⇨" name="Concediaza">
    </form>
</div>

</div>
</body>
</html>
