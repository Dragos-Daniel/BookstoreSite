
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
</head>
<body>

<ul>
    <li><a href="login.php">Delogare</a></li>
    <li><a class="active" href="index.php">Acasa</a></li>
    <li><a href="register.php">Inregistrari</a></li>
    <li><a href="comenzi.php">Adaugare Comenzi</a></li>
    <li><a href="GestAng.php">Gestionare Angajati</a></li>
    <li><a href="ExpComenzi.php">Expediere Comenzi</a></li>


</ul>

<div class="ang_an">
    <span>Reprezentantele si managerii lor: </span>
    <?php
    require_once ('connection.php');
    $query = "SELECT A.Nume_Reprezentanta, B.Nume, B.Prenume  
 FROM Reprezentanta A
 JOIN Salariati B on A.ID_Manager = B.ID_Salariat";
    $run=sqlsrv_query($conn,$query);

    echo "<table>
<tr>
<th>Nume Reprezentanta </th>
<th>Nume Manager </th>
<th>Prenume Manager</th>
</tr>";
    while($row = sqlsrv_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['Nume_Reprezentanta'] . "</td>";
        echo "<td>" . $row['Nume'] . "</td>";
        echo "<td>" . $row['Prenume'] . "</td>";
    }
    echo "</table>";
    ?>

</div>
<br><br>
<!--QUERY-URI SIMPLE SI COMPLEXE-->
<div class="ang_an">
    <span>Managerul Reprezentantei cu cei mai multi angajati: </span>
    <?php
    require_once ('connection.php');
    $query = "SELECT A.Nume, A.Prenume, B.Nume_Reprezentanta 
From Salariati A 
JOIN Reprezentanta B ON A.ID_Salariat = B.ID_Manager
WHERE B.ID_Reprezentanta = (SELECT TOP 1 C.ID_Reprezentanta 
						   FROM Reprezentanta C JOIN Salariati D on C.ID_Reprezentanta = D.ID_Reprezentanta
						   GROUP BY C.ID_Reprezentanta
						   order by COUNT(D.ID_Salariat) desc)";
    $run=sqlsrv_query($conn,$query);

    echo "<table>
<tr>
<th>Nume Manager  </th>
<th>Prenume Manager</th>
<th>Nume Reprezentanta</th>
</tr>";
    while($row = sqlsrv_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['Nume'] . "</td>";
        echo "<td>" . $row['Prenume'] . "</td>";
        echo "<td>" . $row['Nume_Reprezentanta'] . "</td>";
    }
    echo "</table>";
    ?>

</div>
<br><br>
<div class="ang_an">
    <span>Angajatul lunii: </span>
    <?php
    require_once ('connection.php');
    $query = "SELECT A.Nume, A.Prenume, COUNT(B.ID_Produs) as Total_Produse
FROM Salariati A 
JOIN Salariat_Produs B ON B.ID_Salariat=A.ID_Salariat
GROUP BY A.ID_Salariat,A.Nume, A.Prenume
 HAVING COUNT(B.ID_Produs) = (SELECT TOP 1 COUNT(C.ID_Produs) FROM Salariat_Produs C GROUP BY C.ID_Salariat ORDER BY COUNT(C.ID_Produs) desc )";
    $run=sqlsrv_query($conn,$query);

echo "<table>
<tr>
<th>Nume </th>
<th>Prenume </th>
<th>Total Proiecte Lucrate</th>
</tr>";
while($row = sqlsrv_fetch_array($run)) {
    echo "<tr>";
    echo "<td>" . $row['Nume'] . "</td>";
    echo "<td>" . $row['Prenume'] . "</td>";
    echo "<td>" . $row['Total_Produse'] . "</td>";
}
echo "</table>";
?>

</div>
<br><br>
<div class="ang_an">
<span>Cel mai preferat tip de produs de catre clienti: </span>
<?php
require_once ('connection.php');
$query = " SELECT A.Nume_Tip, COUNT(C.ID_Produs) as Total_Comenzi
 FROM Tip_Produs A 
 JOIN Produs B ON A.ID_Tip = B.ID_Tip
 JOIN Produs_Client C ON B.ID_Produs = C.ID_Produs
 GROUP BY a.Nume_tip
 HAVING COUNT(C.ID_Produs) = (SELECT TOP 1 COUNT(C.ID_Produs) FROM Produs_Client C GROUP BY C.ID_Produs ORDER BY COUNT(C.ID_Produs) desc )";
$run=sqlsrv_query($conn,$query);

echo "<table>
<tr>
<th>Nume </th>
<th>Total Comenzi pe tip</th>
</tr>";
while($row = sqlsrv_fetch_array($run)) {
    echo "<tr>";
    echo "<td>" . $row['Nume_Tip'] . "</td>";
    echo "<td>" . $row['Total_Comenzi'] . "</td>";
}
echo "</table>";
?>

</div>

<br><br>

<div class="ang_an">
    <span>Cel mai fidel Client: </span>
    <?php
    require_once ('connection.php');
    $query = " SELECT TOP 1 A.Nume_Client, A.Prenume_Client, COUNT(B.ID_PRODUS) AS Total_comenzi 
 FROM Client A 
 LEFT JOIN Produs_Client B ON A.ID_Client = B.ID_Client
 GROUP BY A.Nume_Client, A.Prenume_Client
 Order by COUNT(B.ID_Produs) desc";
    $run=sqlsrv_query($conn,$query);

    echo "<table>
<tr>
<th>Nume </th>
<th>Total Comenzi:</th>
</tr>";
    while($row = sqlsrv_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['Nume_Client'] .$row['Prenume_Client']. "</td>";
        echo "<td>" . $row['Total_comenzi'] . "</td>";
    }
    echo "</table>";
    ?>

</div>
<br><br>
<div class="ang_an">
    <span>Clientul cu cea mai mare comanda din luna: </span>
    <form method = POST action = "index.php">
        <label for="Luna_curenta"></label>
        <input type="text" name="Luna_curenta" required>
        <input type="submit" value="Verifica ⇨" name="Luna">
    </form>
    <?php
    require_once ('connection.php');
    if(isset($_POST['Luna'])) {
        $luna = $_POST["Luna_curenta"];
        $query = " SELECT TOP 1 A.Nume_Client, A.Prenume_Client, B.Cantitate_Cump as Total_Cant
 FROM Client A 
 JOIN Produs_Client B ON A.ID_Client = B.ID_Client
 where month(B.Data_Expediere) = '$luna'
 ORDER BY B.Cantitate_Cump desc";
        $run = sqlsrv_query($conn, $query);
    }

    echo "<table>
<tr>
<th>Nume </th>
<th>Total Comenzi:</th>
</tr>";
    while($row = sqlsrv_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['Nume_Client'] .$row['Prenume_Client']. "</td>";
        echo "<td>" . $row['Total_Cant'] . "</td>";
    }
    echo "</table>";
    ?>


</div>

<br><br>
<div class="ang_an">
    <span>Angajatul cu cel mai mic raport Salariu/Produse lucrate: </span>
    <?php
    require_once ('connection.php');
    $query = "SELECT A.Nume, A.Prenume 
FROM Salariati A
WHERE A.ID_Salariat IN(SELECT TOP 1 B.ID_Salariat 
						FROM Salariati B
						JOIN Salariat_Produs C ON B.ID_Salariat = C.ID_Salariat
						GROUP BY B.ID_Salariat,B.Salariu
						ORDER BY  B.Salariu/Count(C.ID_Produs) ASC)";
    $run=sqlsrv_query($conn,$query);

    echo "<table>
<tr>
<th>Nume </th>
<th>Prenume </th>
</tr>";
    while($row = sqlsrv_fetch_array($run)) {
        echo "<tr>";
        echo "<td>" . $row['Nume'] . "</td>";
        echo "<td>" . $row['Prenume'] . "</td>";
    }
    echo "</table>";
    ?>

</div>


</body>
</html>
