<!-- Dies dient als Anbindung zur Datenbank. Es wird ein PDO verwendet.-->
<?php

// Die IP der Datenbank.
$host = "127.0.0.1";
// Der User, der die Verbindung aufbaut.
$user = "root";
// Der Name der Datenbank.
$db = "abschlussprojekt";

// Es wird über eine try catch objekt überprüft, ob eine Verbindung möglich ist, wenn nicht wird der fehler ausgegeben.
try {
	$dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user);
	// echo "Connected<p>";
}
catch (Exception $e) {
	echo "Unable to connect: " . $e->getMessage() ."<p>";
}
?>