<?php

session_start();

require_once("../config/connexion.php");

if(isset($_GET['vider']))
{
    mysqli_query($conn, "TRUNCATE TABLE historique");

    header("Location: historique.php");
    exit();
}

require_once("../config/connexion.php");

$sql = "SELECT * FROM historique ORDER BY date_action DESC";
$resultat = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Historique GTB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<a href="?vider=1"
class="btn btn-danger mb-3"
onclick="return confirm('Voulez-vous vraiment supprimer tout l historique ?');">
🗑 Vider l'historique
</a>
<div class="container mt-5">

<h2>📜 Historique des Actions</h2>

<br>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Utilisateur</th>
<th>Action</th>
<th>Date</th>
</tr>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['id']; ?></td>

<td><?php echo $ligne['utilisateur']; ?></td>

<td><?php echo $ligne['action_effectuee']; ?></td>

<td><?php echo $ligne['date_action']; ?></td>

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