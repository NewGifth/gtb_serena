<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../config/connexion.php");

$sql = "SELECT * FROM temperature
        WHERE valeur > 28
        OR valeur < 18";

$resultat = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Alertes GTB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>⚠️ Centre des Alertes</h2>

<br>

<table class="table table-bordered">

<tr>
<th>Zone</th>
<th>Température</th>
<th>Alerte</th>
</tr>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['zone']; ?></td>

<td><?php echo $ligne['valeur']; ?> °C</td>

<td>

<?php

if($ligne['valeur'] > 28)
{
    echo "<span class='badge bg-danger'>
    Température élevée
    </span>";
}
else
{
    echo "<span class='badge bg-warning text-dark'>
    Température basse
    </span>";
}

?>

</td>

</tr>

<?php } ?>

</table>

<a href="../dashboard.php"
class="btn btn-primary">
Retour Dashboard
</a>

</div>

</body>
</html>