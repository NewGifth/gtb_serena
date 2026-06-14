<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../config/connexion.php");

/* Ajout utilisateur */

if(isset($_POST['ajouter']))
{
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    mysqli_query($conn,
    "INSERT INTO utilisateurs(nom,email,mot_de_passe)
    VALUES('$nom','$email','$mot_de_passe')");
}

/* Suppression */

if(isset($_GET['supprimer']))
{
    $id = intval($_GET['supprimer']);

    mysqli_query($conn,
    "DELETE FROM utilisateurs WHERE id=$id");
}

$sql = "SELECT * FROM utilisateurs";
$resultat = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Gestion Utilisateurs</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>👥 Gestion des Utilisateurs</h2>

<br>

<form method="POST">

<div class="row">

<div class="col-md-4">
<input type="text" name="nom"
class="form-control"
placeholder="Nom"
required>
</div>

<div class="col-md-4">
<input type="email" name="email"
class="form-control"
placeholder="Email"
required>
</div>

<div class="col-md-4">
<input type="text" name="mot_de_passe"
class="form-control"
placeholder="Mot de passe"
required>
</div>

</div>

<br>

<button type="submit"
name="ajouter"
class="btn btn-success">
Ajouter
</button>

</form>

<hr>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['id']; ?></td>

<td><?php echo $ligne['nom']; ?></td>

<td><?php echo $ligne['email']; ?></td>

<td>

<a href="?supprimer=<?php echo $ligne['id']; ?>"
class="btn btn-danger btn-sm">
Supprimer
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