<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Accesso Utente</title>
		<meta name="description" content="Pagina di prova per accesso utente"/>
		<script>function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
} </script>
	</head>
	<?php
		define('__EVA_HOME__', $_SERVER['DOCUMENT_ROOT'] . '/eva');
		include  $_SERVER["DOCUMENT_ROOT"] . '/eva/functions/default.php';
		include  $_SERVER["DOCUMENT_ROOT"] . '/eva/classes/logUser.php';
		EVA\settings::boot();
		EVA\dbFactory::boot();
		if(isset($_GET['action']) and $_GET['action'] == 'logout') {
			EVA\logUser::logout();
		}
		else {
			$user = EVA\logUser::login();
		}
	?>
	<body>
		<div>
			<div style="margin: 0 auto; text-align: center; width: 500px">
				<form method="post" action="">
					<fieldset>
						<legend>Area di Accesso:</legend>
						<label for="userName">nome utente:</label><br/>
						<input type="text" id="userName" name="userName"><br/>
						<label for="userName">password:</label><br/>
						<input type="password" id="password" name="password"><br/>
						 <input type="submit" value="Accedi">
						 <input type="button" onclick="alert('Ciao ' + getCookie('userName'))" value="Salutami!"><br/>
						 <a href="?action=logout">disconnetti</a>
					</fieldset>
				</form>
			</div>
			<div>
				<p>Risultato: <?php if(isset($user) and $user != false) { echo 'Nome Utente: ' . $user->getUserName() . ', email: ' . $user->getEmail(); } else echo '$user = false'; ?></p>
			</div>
		</div>
	</body>
</html>