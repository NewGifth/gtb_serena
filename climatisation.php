<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../config/connexion.php");

if(isset($_GET['action']) && isset($_GET['id']))
{
    $id = intval($_GET['id']);
    $zone_req = mysqli_query($conn,
"SELECT zone FROM climatisation WHERE id=$id");

$zone_data = mysqli_fetch_assoc($zone_req);

$zone = $zone_data['zone'];

    if($_GET['action']=="on")
    {
        mysqli_query($conn,
        "UPDATE climatisation SET etat='ON' WHERE id=$id");
        $zone_req = mysqli_query($conn,
"SELECT zone FROM climatisation WHERE id=$id");

$zone_data = mysqli_fetch_assoc($zone_req);

$zone = $zone_data['zone'];

        mysqli_query($conn,
        "INSERT INTO historique(utilisateur, action_effectuee)
        VALUES(
        '".$_SESSION['nom']."',
        'Activation de la climatisation - $zone'
        )");
    }

    if($_GET['action']=="off")
    {
        mysqli_query($conn,
        "UPDATE climatisation SET etat='OFF' WHERE id=$id");

        mysqli_query($conn,
        "INSERT INTO historique(utilisateur, action_effectuee)
        VALUES(
        '".$_SESSION['nom']."',
        'Desactivation de la climatisation - $zone'
        )");
    }

    header("Location: climatisation.php");
    exit();
}

$sql = "SELECT * FROM climatisation";
$resultat = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Gestion Climatisation</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>

.clim-on{
    font-size:45px;
    color:#00BFFF;
    text-shadow:
    0 0 10px #00BFFF,
    0 0 20px #00BFFF,
    0 0 30px #00BFFF;
}

.clim-off{
    font-size:45px;
    color:#777;
}

</style>
</head>

<body>

<div class="container mt-5">

<h2>❄ Gestion de la Climatisation</h2>

<br>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Zone</th>
<th>Température</th>
<th>État</th>
<th>Actions</th>
</tr>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['id']; ?></td>

<td><?php echo $ligne['zone']; ?></td>

<td><?php echo $ligne['temperature_reglee']; ?> °C</td>

<td>

<?php

if($ligne['etat']=="ON")
{
    echo "
    <i class='fas fa-snowflake clim-on'></i>
    <br>
    <span class='badge bg-success'>ON</span>
    ";
}
else
{
    echo "
    <i class='fas fa-snowflake clim-off'></i>
    <br>
    <span class='badge bg-danger'>OFF</span>
    ";
}

?>

</td>

<td>

<a href="?action=on&id=<?php echo $ligne['id']; ?>"
class="btn btn-success btn-sm">
ON
</a>

<a href="?action=off&id=<?php echo $ligne['id']; ?>"
class="btn btn-danger btn-sm">
OFF
</a>

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