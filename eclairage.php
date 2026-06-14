<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../config/connexion.php");

/* Gestion ON/OFF */

if(isset($_GET['action']) && isset($_GET['id']))
{
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    $zone_req = mysqli_query($conn,
"SELECT zone FROM eclairage WHERE id=$id");

$zone_data = mysqli_fetch_assoc($zone_req);

$zone = $zone_data['zone'];

    if($action == "on")
    {
        mysqli_query($conn,
        "UPDATE eclairage SET etat='ON' WHERE id=$id");

        mysqli_query($conn,
        "INSERT INTO historique(utilisateur,action_effectuee)
         VALUES(
         '".$_SESSION['nom']."',
         'Activation de l eclairage - $zone'
         )");
    }

    if($action == "off")
    {
        mysqli_query($conn,
        "UPDATE eclairage SET etat='OFF' WHERE id=$id");

        mysqli_query($conn,
        "INSERT INTO historique(utilisateur,action_effectuee)
         VALUES(
         '".$_SESSION['nom']."',
         'Desactivation de l eclairage - $zone'
         )");
    }

    header("Location: eclairage.php");
    exit();

}

$sql = "SELECT * FROM eclairage";
$resultat = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Gestion Éclairage</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>

.lampe-on{
    font-size:45px;
    color:#FFD700;
    text-shadow:
    0 0 10px #FFD700,
    0 0 20px #FFD700,
    0 0 30px #FFD700;
}

.lampe-off{
    font-size:45px;
    color:#666;
}

</style>
</head>

<body>

<div class="container mt-5">

<h2>💡 Gestion de l'Éclairage</h2>

<br>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Zone</th>
<th>État</th>
<th>Actions</th>
</tr>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['id']; ?></td>

<td><?php echo $ligne['zone']; ?></td>

<td>

<?php

if($ligne['etat']=="ON")
{
    echo "
    <i class='fas fa-lightbulb lampe-on'></i>
    <br>
    <span class='badge bg-success'>ON</span>
    ";
}
else
{
    echo "
    <i class='fas fa-lightbulb lampe-off'></i>
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