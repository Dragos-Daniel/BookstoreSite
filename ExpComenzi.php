
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="ExpComenzi.css">
</head>
<body>

<ul>
    <li><a href="login.php">Delogare</a></li>
    <li><a href="index.php">Acasa</a></li>
    <li><a href="register.php">Inregistrari</a></li>
    <li><a href="comenzi.php">Adaugare Comenzi</a></li>
    <li><a href="GestAng.php">Gestionare Angajati</a></li>
    <li><a class="active" href="ExpComenzi.php">Expediere Comenzi</a></li>

</ul>
<p> Situatie Comenzi </p>
<?php
//lista cu toate comenzile
require_once ('connection.php');
$query ="SELECT B.Nume_Client, B.Prenume_Client,B.Tip_Client, C.Nume_Produs,A.Cantitate_Cump,A.Numar_Comanda,A.Data_Expediere FROM Produs_Client A JOIN Client B ON A.ID_Client=B.ID_Client JOIN Produs C ON A.ID_Produs= C.ID_Produs";
$run=sqlsrv_query($conn,$query);
echo "<table>
<tr>
<th>Nume Client</th>
<th>Prenume Client</th>
<th>Tip Client</th>
<th>Nume Produs</th>
<th>Cantitate cumparata</th>
<th>Numar Comanda</th>
<th>Data expediere</th>

</tr>";

while($row = sqlsrv_fetch_array($run))

{
    echo "<tr>";
    echo "<td>" . $row['Nume_Client'] . "</td>";
    echo "<td>" . $row['Prenume_Client'] . "</td>";
    echo "<td>" . $row['Tip_Client'] . "</td>";
    echo "<td>" . $row['Nume_Produs'] . "</td>";
    echo "<td>" . $row['Cantitate_Cump'] . "</td>";
    echo "<td>" . $row['Numar_Comanda'] . "</td>";
    echo "<td>" . $row['Data_Expediere']->format('d/m/Y') . "</td>";
    echo "</tr>";
}
echo "</table>";

if(isset($_POST['Expediaza']))
//expediere comenzi(delete) pentru un anume tip de client(pju/pfa)
{
    $tip= $_POST['TipClient'];
    $delete = "DELETE FROM Produs_Client WHERE ID_Client IN (SELECT B.ID_Client FROM Client B WHERE B.Tip_Client = '$tip')";
    $run = sqlsrv_query($conn,$delete);

}
?>
<br>
<div>
    <form method= POST action = "ExpComenzi.php">
        Trimiteti spre livrare comenzile persoanelor din categoria:
        <label for="TipClient">  </label>
        <select name="TipClient" id="TipClient">
            <option name = "PFA" value="PFA" >PFA</option>
            <option name = "PJU" value="PJU" >PJU</option>
        </select>

        <input type="submit" value="Trimite ⇨" name="Expediaza">
    </form>
</div>
</body>
</html>
