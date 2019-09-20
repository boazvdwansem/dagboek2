<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
require_once 'forms/connection.php';
?>
<body>

<!-- START NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Dagboek</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="inloggen.php">Inloggen</a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="registreren.php">Registreren</a>
      </li>
    </ul>
  </div>
</nav>
<!-- EIND NAVBAR -->

<div class="container">
  <div class="row">
    <div class="col">
	<h1>Registreren</h1>
	<form method='POST'>
	<div class="form-group">
		<label for="Gebruikersnaam">Voornaam</label>
		<input type="text" name="voornaam" class="form-control" id="gebruikersnaam" aria-describedby="Gebruikersnaam" placeholder="Voer uw gebruikersnaam in...">
	</div>
	<div class="form-group">
		<label for="Tussenvoegsels">Tussenvoegsel</label>
		<input type="text" name="tussenvoegsels" class="form-control" id="tussenvoegsels" aria-describedby="tussenvoegsels" placeholder="Voer uw tussenvoegsels in...">
	</div>
	<div class="form-group">
		<label for="Achternaam">Achternaam</label>
		<input type="text" name="achternaam" class="form-control" id="achternaam" aria-describedby="achternaam" placeholder="Voer uw achternaam in...">
	</div>
	  <div class="form-group">
		<label for="Email">Email</label>
		<input type="email" name="email" class="form-control" id="email" aria-describedby="email" placeholder="Voer uw email in...">
	</div>
	  <div class="form-group">
		<label for="Email2">Email opnieuw</label>
		<input type="email" name="email2" class="form-control" id="email2" aria-describedby="email" placeholder="Voer uw email opnieuw in...">
	</div>
	<div class="form-group">
		<label for="Wachtwoord">Wachtwoord</label>
		<input type="password" name="wachtwoord" class="form-control" id="wachtwoord" placeholder="Voer uw wachtwoord in...">
    </div>
	<div class="form-group">
		<label for="Wachtwoord">Wachtwoord opnieuw</label>
		<input type="password" name="wachtwoord2" class="form-control" id="wachtwoord2" placeholder="Voer uw wachtwoord opnieuw in...">
    </div>
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="exampleCheck1">
		<label class="form-check-label" for="exampleCheck1">Check me out</label>
	</div>
	<br>
  <button type="submit" class="btn btn-primary">Aanmaken</button>
  <button class="btn btn-secondary" href="index.php">Annuleren</button>
</form>

</div>
</div>
</div>
</body>
<?php
	
if($_SERVER['REQUEST_METHOD'] == 'POST'){

$stmt = $pdo->prepare("INSERT INTO `gebruikers` (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES (:voornaam, :tussenvoegsels, :achternaam, :email, :wachtwoord)");
$stmt->bindParam(':voornaam', $voornaam);
$stmt->bindParam(':tussenvoegsels', $tussenvoegsels);
$stmt->bindParam(':achternaam', $achternaam);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':wachtwoord', $hash);

$voornaam = $_POST['voornaam'];
$tussenvoegsels = $_POST['tussenvoegsels'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$email2 = $_POST['email2'];
$wachtwoord = $_POST['wachtwoord'];
$wachtwoord2 = $_POST['wachtwoord2'];

$hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

if(($email === $email2) && ($wachtwoord === $wachtwoord2)){
$stmt->execute();
$stmt = null;
} elseif($email !== $email2) {
	$error = "De ingevoerde emails komen niet overeen.";
} elseif($wachtwoord !== $wachtwoord2){
	$error = "De wachtwoorden komen niet overeen.";
}

if(isset($error)){
	echo $error;
}


/*
$stmt = $pdo->prepare("INSERT INTO gebruikers (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES ($voornaam, $tussenvoegsels, $achternaam, $email, $wachtwoord)");
$stmt->execute(44, $voornaam, $tussenvoegsels, $achternaam, $email, $wachtwoord);
$stmt = null;*/
}
?>
</html>