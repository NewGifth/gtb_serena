<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../login.php");
    exit();
}

require_once("../config/connexion.php");

$sql = "SELECT * FROM temperature";
$resultat = mysqli_query($conn,$sql);$total_zones = mysqli_num_rows($resultat);
$zones = [];
$valeurs = [];

$sql_graph = "SELECT * FROM temperature";
$res_graph = mysqli_query($conn,$sql_graph);

while($row = mysqli_fetch_assoc($res_graph))
{
    $zones[] = $row['zone'];
    $valeurs[] = $row['valeur'];
}
$sql_moyenne = "SELECT AVG(valeur) AS moyenne FROM temperature";
$res_moyenne = mysqli_query($conn,$sql_moyenne);
$data_moyenne = mysqli_fetch_assoc($res_moyenne);

$temperature_moyenne = round($data_moyenne['moyenne'],1);

$sql_alertes = "SELECT COUNT(*) AS total FROM temperature WHERE etat='Alerte'";
$res_alertes = mysqli_query($conn,$sql_alertes);
$data_alertes = mysqli_fetch_assoc($res_alertes);

$total_alertes = $data_alertes['total'];

mysqli_data_seek($resultat,0);

?>


<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Température GTB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>🌡 Surveillance des Températures</h2>
<div class="row mb-4">

<div class="col-md-4 mb-3">

<div class="card bg-primary text-white">

<div class="card-body">

<h5>Zones surveillées</h5>

<h2><?php echo $total_zones; ?></h2>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card bg-success text-white">

<div class="card-body">

<h5>Température moyenne</h5>

<h2><?php echo $temperature_moyenne; ?>°C</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card bg-danger text-white">

<div class="card-body">

<h5>Alertes</h5>

<h2><?php echo $total_alertes; ?></h2>

</div>

</div>

</div>

</div>

<br>
<div class="card mb-4">

<div class="card-header">
📈 Graphique des Températures
</div>

<div class="card-body">

<canvas id="temperatureChart"></canvas>

</div>

</div>

<table class="table table-bordered table-striped">

<thead>

<tr>
<th>ID</th>
<th>Zone</th>
<th>Température</th>
<th>État</th>
</tr>

</thead>

<tbody>

<?php while($ligne=mysqli_fetch_assoc($resultat)){ ?>

<tr>

<td><?php echo $ligne['id']; ?></td>

<td><?php echo $ligne['zone']; ?></td>

<td><?php echo $ligne['valeur']; ?> °C</td>

<td>

<?php

if($ligne['etat']=="Alerte")
{
    echo "<span class='badge bg-danger'>Alerte</span>";
}
else
{
    echo "<span class='badge bg-success'>Normal</span>";
}

?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<a href="../dashboard.php" class="btn btn-primary">
Retour Dashboard
</a>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctx = document.getElementById('temperatureChart');

new Chart(ctx, {

type: 'bar',

data: {

labels: <?php echo json_encode($zones); ?>,

datasets: [{
label: 'Température (°C)',
data: <?php echo json_encode($valeurs); ?>,
borderWidth: 1
}]

},

options: {

responsive: true,

scales: {
y: {
beginAtZero: true
}
}

}

});

</script>
</body>
</html>