<?php
session_start();
require_once("config/connexion.php");

$message = "";

if(isset($_POST['connexion']))
{
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs 
            WHERE email='$email' 
            AND mot_de_passe='$mot_de_passe'";

    $resultat = mysqli_query($conn, $sql);

    if(mysqli_num_rows($resultat) > 0)
    {
        $user = mysqli_fetch_assoc($resultat);

        $_SESSION['id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

header("Location: dashboard.php");
exit();
    
    }
    else
    {
        $message = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GTB Serena - Connexion</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background: linear-gradient(135deg,#0f172a,#1e3a8a);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-card{
    width:420px;
    background:white;
    border-radius:20px;
    padding:35px;
    box-shadow:0px 15px 40px rgba(0,0,0,0.3);
}

.logo{
    text-align:center;
    font-size:70px;
}

.title{
    text-align:center;
    color:#1e3a8a;
    font-weight:bold;
}

.subtitle{
    text-align:center;
    color:gray;
    margin-bottom:25px;
}

.btn-login{
    background:#1e3a8a;
    color:white;
    width:100%;
}

.btn-login:hover{
    background:#0f172a;
    color:white;
}

</style>

</head>

<body>

<div class="login-card">

<div class="logo">
🏢
</div>

<h2 class="title">GTB SERENA</h2>

<p class="subtitle">
Gestion Technique de Bâtiment
</p>

<?php if($message!="") { ?>

<div class="alert alert-danger">
    <?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

<div class="mb-3">
<label>Email</label>
<input type="email"
       name="email"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label>Mot de passe</label>
<input type="password"
       name="mot_de_passe"
       class="form-control"
       required>
</div>

<button type="submit"
        name="connexion"
        class="btn btn-login">
    Se connecter
</button>

</form>

</div>

</body>
</html>