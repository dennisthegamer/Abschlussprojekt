<?php
Session_Start();
error_reporting(0);
require "../function/connection.php";
// require "../function/functions.php";

// Mit dieser if abfrage wird sichergestellt das der User eingelogt ist, wenn nicht wird er zur "login" page weitergeleitet.
if (!isset($_SESSION["gruppe"])) {
  header("Location: ../login/login.php");
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schwarzesbrett</title>
  <link rel="stylesheet" href="style.css">
  <!-- ein automatischer reload der alle 10 Min ausgeführt wird. -->
  <meta http-equiv="refresh" content="30; url=board.php">
</head>

<!-- beim laden der Website wird die Uhr automatisch mitgeladen. -->

<body onload="starteUhr()">

  <div id="komp">
    <div class="grid-container">
      <div class="welcom">
        <!-- Dieser div container beschäftigt sich mit der ausgabe für die Wilkommensnachricht -->
        <?php
        $gruppe = $_SESSION[gruppe];

        $stmt = $dbh->query("SELECT gruppe FROM user where gruppe = '$_SESSION[gruppe]' ORDER BY id");

        while ($row = $stmt->fetch()) {

          $grupn = $row['gruppe'];
        }

        echo '<div class="wel">' .
          ' <h1 style="margin-left: 10px;">' . 'Herzlich Willkommen' . '</h1>' . '
  <h1 style="margin-left: 10px;">' . 'auf: ' . $grupn . '</h1> ';
        ?>

      </div>
      <!-- Dieser div container beschäftigt sich mit der ausgabe für die Uhrzeit und das Datum-->
      <div class="time">
        <script>
          // die JavaScript funktion gibt die Uhrzeit für "date" aus
          function starteUhr() {
            var heute = new Date();
            var s = heute.getHours();
            var m = heute.getMinutes();
            var sek = heute.getSeconds();
            m = checkTime(m);
            sek = checkTime(sek);
            document.getElementById('txt').innerHTML =
              s + ":" + m + ":" + sek;
            var t = setTimeout(starteUhr, 500);
          }
          // setzt eine 0 vor die Zahlen die kleiner als 10 sin
          function checkTime(i) {
            if (i < 10) {
              i = "0" + i
            };
            return i;
          }

          var datum = new Date()
          var jahr = datum.getFullYear()

          var tag = datum.getDate()

          // checken des Monats 
          function monat1() {
            var monat = datum.getMonth()

            if (monat == 0) document.write("Januar");
            if (monat == 1) document.write("Februar");
            if (monat == 2) document.write("März");
            if (monat == 3) document.write("April");
            if (monat == 4) document.write("Mai");
            if (monat == 5) document.write("Juni");
            if (monat == 6) document.write("Juli");
            if (monat == 7) document.write("August");
            if (monat == 8) document.write("September");
            if (monat == 9) document.write("Oktober");
            if (monat == 10) document.write("November")
            if (monat == 11) document.write("Dezember")
          }


          // Checken des Wochentages
          function wotag() {
            var datum = new Date()
            var wochentag = datum.getDay()

            if (wochentag == 0) document.write("Sonntag");
            if (wochentag == 1) document.write("Montag");
            if (wochentag == 2) document.write("Dienstag");
            if (wochentag == 3) document.write("Mittwoch");
            if (wochentag == 4) document.write("Donnerstag");
            if (wochentag == 5) document.write("Freitag");
            if (wochentag == 6) document.write("Samstag");

          }

          // ausgabe des Wocnhentages
          wotag()
          document.write(" - ")
          document.write(tag, ". ")
          // ausgabe des Monats
          monat1()
          document.write(" ", jahr)
        </script>
        <br>

        <div id="txt"></div>
      </div>

      <!-- Dieser div container beschäftigt sich mit der ausgabe für das "Wetter" durch die API  -->
      <div class="wether">
        <br>


        <?php
        // abruf der geforderten Daten aus der Datenbank
        $stmt = $dbh->query("SELECT ort FROM wetter where gruppe = '$_SESSION[gruppe]' ORDER BY id");

        // über die schleife wird eine neue Variable erstllt mit dem Inhalt der Datenbank
        while ($row = $stmt->fetch()) {

          $ort = $row['ort'];
        }

        // Der API Key dient für die Authentifizierung bei openweathermap.org 
        $apiKey = "e44949b736b8119ed26043f83d68ebfc";
        $cityId = "6553265";
        // variable ort aus der DB, apikey, Celsius anzeige und deutsche Sprache
        $apiurl = "api.openweathermap.org/data/2.5/weather?q=" . $ort . "&appid=" . $apiKey . "&units=metric&lang=de";

        // curl_setopt - ein cURL-Transfer-Optionen eingestellt
        $ch = curl_init();
        // werte zum abfragen
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        ?>

        <div class="report-container">
          <!-- Dieser Div gibt die ausgabe für die Wetterbeschreibung -->
          <div class="time_wetter">
            <br>

            <div class="wetterlwa"> <?php echo ucwords($data->weather[0]->description); ?> </div>
          </div>
          <!-- ausgabe für das Wetter als Bild und Temperatur -->
          <div class="weather-forecast">
            <img src="http://api.openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" /> <?php echo $data->main->temp; ?> &deg;C

          </div>

          <!-- ausgabe für Feuchtigkeit und Windgeschwindigkeit -->
          <div class="time_wetter">
            <div class="wetterlwa"> Feuchtigkeit: <?php echo $data->main->humidity; ?> %</div>
            <br>
            <div class="wetterlwa"> Wind: <?php echo $data->wind->speed; ?> kmh</div>


          </div>
        </div>
      </div>
    </div>

    <!-- Dieser div container beschäftigt sich mit der ausgabe für die "Veranstaltungen" (in Textform) -->
    <div class="ver">
      <h1 class="h1_board"> Veranstaltungen</h1>


      <!-- Diese Tabelle spiegelt das selbe wie oben wieder, nur mit den anderen Parametern. -->
      <table class="verfront">
        <tr>
          <th>Name</th>
          <th>Wann</th>
          <th>Wo</th>
        </tr>
        <?php
        // abruf der geforderten Daten aus der Datenbank
        $stmt = $dbh->query("SELECT namev, wann, wo FROM eventsnrml where gruppe = '$_SESSION[gruppe]' ORDER BY id");

        // über die Schleife werden alle Daten in form einer Tabelle ausgegeben
        while ($row = $stmt->fetch()) {

          echo '<tr>';
          echo '<td>' . $row['namev'] . '</td>';
          echo '<td>' . date('j M Y - H:i', strtotime($row['wann'])) . " Uhr" . '</td>';
          echo '<td>' . $row['wo'] . '</td>';

        ?>

        <?php
          echo '</tr>';
        }
        ?>
      </table>

    </div>
    <!-- ausgabe des Logos links unten -->
    <div class="pic">

      <img id="blume" src="../pics/bunteblume.jpg" alt="">

    </div>

    <!-- Dieser div container beschäftigt sich mit der ausgabe für die "Nachrichten" -->
    <div class="news">
      <h1 class="h1_board">Nachrichten</h1>
      <table class="verfront">
        <tr>
          <th>Nachricht</th>
          <th>Datum</th>
        </tr>
        <?php
        // abruf der geforderten Daten aus der Datenbank
        $stmt = $dbh->query("SELECT nachricht, datum FROM news where gruppe = '$_SESSION[gruppe]' ORDER BY id  ");

        // über die Schleife werden alle Daten in form einer Tabelle ausgegeben
        while ($row = $stmt->fetch()) {

          echo '<tr>';
          echo '<td>' . $row['nachricht'] . '</td>';
          echo '<td>' . date('j M Y - H:i', strtotime($row['datum'])) . " Uhr" . '</td>';

        ?>

        <?php
          echo '</tr>';
        }
        ?>
      </table>
    </div>
    <div class="slide">
      <div id="slider">
        <figure>


          <?php
          // abruf der geforderten Daten aus der Datenbank
          $stmt = $dbh->query("SELECT name FROM events where gruppe = '$_SESSION[gruppe]'  ORDER BY id ");

          // über die Schleife werden alle Daten in form von img dateien ausgegeben
          while ($row = $stmt->fetch()) {
            echo '<div class="TEST_bild"> <img src= ../pics/' . $row['name'] . '> </div>';
          }
          ?>
        </figure>
      </div>
    </div>

    <!-- Dieser div container beschäftigt sich mit der ausgabe für die "Erreichbare Person / Gruppe". -->
    <div class="tel">
      <h1 class="h1_board">Telefonnr</h1>
      <table class="posttab">
        <tr>
          <th> Erreichbar ist: </th>
        </tr>
        <?php
        // abruf der geforderten Daten aus der Datenbank
        $stmt = $dbh->query("SELECT id, mitarbeiter FROM erreichbar where gruppe = '$_SESSION[gruppe]' ORDER BY id");

        // über die Schleife werden alle Daten in form einer Tabelle ausgegeben
        while ($row = $stmt->fetch()) {

          echo '<tr>';
          echo '<td>' . $row['mitarbeiter'] . ',' . ' ' . ' </td>';
        }
        echo '</tr>';

        ?>
      </table>


    </div>

    <!-- Dieser div container beschäftigt sich mit der ausgabe für die "Post" -->
    <div class="post">
      <h1 class="h1_board">Post </h1>
      <h1>Es ist Post da für: </h1>
      <table class="posttab">
        <tr>
          <?php
          // abruf der geforderten Daten aus der Datenbank
          $stmt = $dbh->query("SELECT name FROM post where gruppe = '$_SESSION[gruppe]' ORDER BY id");

          // über die Schleife werden alle Daten in form einer Tabelle ausgegeben
          while ($row = $stmt->fetch()) {
            echo '<th>' . $row['name'] . ',' . ' ' . ' </th>';
          }
          echo '</tr>';

          ?>
      </table>
    </div>
  </div>
  <!-- Von wem das Projekt erstellt wurde. -->
  <div class="botom">
    <h1 style="color: white; text-align: center; font-size:45px;">Created by Dennis Mager </h1>

  </div>
  </div>

</body>

</html>