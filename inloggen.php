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
      <li class="nav-item active">
        <a class="nav-link" href="inloggen.php">Inloggen</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="registreren.php">Registreren</a>
      </li>
    </ul>
  </div>
</nav>
<!-- EIND NAVBAR -->

<div class="container">
  <div class="row">
    <div class="col">
	<h1>Inloggen</h1>
	<form method='POST'>
	  <div class="form-group">
		<label for="Email">Email</label>
		<input type="email" name="email" class="form-control" id="email" aria-describedby="email" placeholder="Voer uw email in...">
	</div>
	<div class="form-group">
		<label for="Wachtwoord">Wachtwoord</label>
		<input type="password" name="wachtwoord" class="form-control" id="wachtwoord" placeholder="Voer uw wachtwoord in...">
    </div>
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="exampleCheck1">
		<label class="form-check-label" for="exampleCheck1">Gegevens onthouden</label>
	</div>
  <button type="submit" class="btn btn-primary">Aanmaken</button>
  <button class="btn btn-secondary" href="index.php">Annuleren</button>
</form>

</div>
</div>
</div>
</body>
	
<?php
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['email']) &&
            isset($_POST['wachtwoord']))
        {
            try
            {
                $loginCheck = "SELECT id_gebruiker FROM gebruikers WHERE email = :email AND wachtwoord = :wachtwoord";
                $stmt = $pdo->prepare($loginCheck);
				$wachtwoord = $_POST['wachtwoord'];
                $stmt->execute(array(
                                    ':email' => $_POST['email'],
                                    ':wachtwoord' => password_hash($wachtwoord, PASSWORD_DEFAULT)
                                    ));
                $user = $stmt->fetchAll();
				
				foreach($user as $user){
					$email = $user['email'];
					echo $email;
				}
				
                
				if ($user == 1)
                {
                    $_SESSION['user'] = array('id_gebruiker' => $user[0]['id_gebruiker'], 'IP' => $_SERVER['REMOTE_ADDR']);
                    //pagina waar naartoe nadat er succesvol is ingelogd
                    header('Location: index.php');
                    die;
                }
                else
                {
						echo "De ingevoerde gegevens zijn onjuist.";
                }
            }
            catch (PDOException $e)
            {
                $message = $e->getMessage();
            }
            $stmt = NULL;
        }
        else
        {
            $message = 'please fill in all required information';
        }
    }
?>
</html>