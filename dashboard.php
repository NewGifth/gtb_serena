<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

require_once("config/connexion.php");
include("meteo.php");

/* Température moyenne */

$sql_temp = "SELECT AVG(valeur) AS moyenne FROM temperature";
$res_temp = mysqli_query($conn, $sql_temp);
$data_temp = mysqli_fetch_assoc($res_temp);
$temperature_moyenne = round($data_temp['moyenne'], 1);

/* Lampes ON */

$sql_lampes = "SELECT COUNT(*) AS total FROM eclairage WHERE etat='ON'";
$res_lampes = mysqli_query($conn, $sql_lampes);
$data_lampes = mysqli_fetch_assoc($res_lampes);
$total_lampes = $data_lampes['total'];

/* Climatisation ON */

$sql_clim = "SELECT COUNT(*) AS total FROM climatisation WHERE etat='ON'";
$res_clim = mysqli_query($conn, $sql_clim);
$data_clim = mysqli_fetch_assoc($res_clim);
$total_clim = $data_clim['total'];

/* Alertes */

$sql_alertes = "SELECT COUNT(*) AS total FROM temperature WHERE etat='Alerte'";
$res_alertes = mysqli_query($conn, $sql_alertes);
$data_alertes = mysqli_fetch_assoc($res_alertes);
$total_alertes = $data_alertes['total'];
$sqlZones = "SELECT * FROM temperature";
$resZones = mysqli_query($conn, $sqlZones);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>GTB Serena Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

<body{
    background:#f4f7fc;
}

html, body{
    overflow-x:hidden;
    width:100%;
}

*{
    box-sizing:border-box;
}
.card-dashboard{
    margin-bottom:20px;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100%;
    background:#0f172a;
    padding-top:20px;
}

.sidebar h3{
    color:white;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 20px;
}

.sidebar a:hover{
    background:#1e3a8a;
}

.main{
    margin-left:250px;
    padding:25px;
}

.card-dashboard{
    border:none;
    border-radius:15px;
    color:white;
}

.temp{
    background:#2563eb;
}

.light{
    background:#f59e0b;
}

.clim{
    background:#10b981;
}

.alertes{
    background:#ef4444;
}

.topbar{
    background:white;
    padding:15px;
    border-radius:15px;
    margin-bottom:20px;
    box-shadow:0px 3px 10px rgba(0,0,0,0.1);
}

.mobile-menu-btn{
    display:none;
    position:fixed;
    top:10px;
    left:10px;
    z-index:9999;
    background:#1e3a8a;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
}

/* VERSION MOBILE */

@media (max-width:768px){

    .mobile-menu-btn{
        display:block;
    }

    .sidebar{
        position:fixed;
        left:-250px;
        top:0;
        width:250px;
        height:100%;
        transition:0.3s;
        z-index:999;
    }

    .sidebar.active{
        left:0;
    }

   .main{
    margin-left:0 !important;
    width:100%;
    padding-top:90px;
    padding-left:15px;
    padding-right:15px;
}
    }

    .row{
        margin:0;
    }
}
</style>
</head>

<body>
<button class="mobile-menu-btn" onclick="toggleMenu()">
☰ Menu
</button>

<div class="sidebar">

<h3>🏢 GTB Serena</h3>

<a href="#"><i class="fa fa-home"></i> Tableau de bord</a>

<a href="temperature/temperature.php">
<i class="fa fa-temperature-half"></i> Température
</a>

<a href="eclairage/eclairage.php">
    <i class="fa fa-lightbulb"></i> Éclairage
</a>

<a href="climatisation/climatisation.php">
<i class="fa fa-snowflake"></i> Climatisation
</a>

<a href="alertes/alertes.php">
<i class="fa fa-triangle-exclamation"></i> Alertes
</a>

<a href="utilisateur/utilisateur.php">
<i class="fa fa-users"></i> Utilisateurs
</a>

<a href="historique/historique.php">
<i class="fa fa-clock-rotate-left"></i> Historique
</a>


<a href="logout.php"><i class="fa fa-right-from-bracket"></i> Déconnexion</a>

</div>

<div class="main">

<div class="topbar">

<h4>
Bienvenue,
<?php echo $_SESSION['nom']; ?>
👋
</h4>

<p>Système de Gestion Technique de Bâtiment</p>

</div>

<div class="row">

<div class="col-12 col-md-6 col-lg-3">

<div class="card card-dashboard temp">
<div class="card-body">

<h5>🌡 Température</h5>

<h2><?php echo $temperature_moyenne; ?>°C</h2>
<p>Température moyenne</p>

</div>
</div>

</div>

<div class="col-md-3">

<div class="card card-dashboard light">
<div class="card-body">

<h5>💡 Éclairage</h5>

<h2><?php echo $total_lampes; ?></h2>

<p>Lampes actives</p>

</div>
</div>

</div>

<div class="col-md-3">

<div class="card card-dashboard clim">
<div class="card-body">

<h5>❄ Climatisation</h5>

<h2><?php echo $total_clim; ?></h2>
<p>Climatiseurs actifs</p>

</div>
</div>

</div>

<div class="col-md-3">

<div class="card card-dashboard alertes">
<div class="card-body">

<h5>⚠ Alertes</h5>

<h2><?php echo $total_alertes; ?></h2>

<p>Alertes système</p>

</div>
</div>

</div>

</div>

<br>

<div class="card">

<div class="card-header">
État du système GTB
</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th>Zone</th>
<th>Température</th>
<th>Éclairage</th>
<th>Climatisation</th>
<th>État</th>
</tr>

<?php while($zone=mysqli_fetch_assoc($resZones)){ ?>

<tr>

<td><?php echo $zone['zone']; ?></td>

<td><?php echo $zone['valeur']; ?>°C</td>

<td>

<?php

$zone_nom = $zone['zone'];

$req_lampe = mysqli_query($conn,
"SELECT etat FROM eclairage WHERE zone='$zone_nom'");

$lampe = mysqli_fetch_assoc($req_lampe);

echo isset($lampe['etat']) ? $lampe['etat'] : "-";

?>

</td>

<td>

<?php

$req_clim = mysqli_query($conn,
"SELECT etat FROM climatisation WHERE zone='$zone_nom'");

$clim = mysqli_fetch_assoc($req_clim);

echo isset($clim['etat']) ? $clim['etat'] : "-";

?>

</td>

<td>

<?php

if($zone['valeur'] >= 30)
{
    echo "<span class='badge bg-danger'>🔥 Critique</span>";
}
elseif($zone['valeur'] >= 28)
{
    echo "<span class='badge bg-warning text-dark'>⚠ Alerte</span>";
}
else
{
    echo "<span class='badge bg-success'>✅ Normal</span>";
}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>
<script>
function toggleMenu()
{
    document.querySelector('.sidebar').classList.toggle('active');
}
</script>
</body>
</html>