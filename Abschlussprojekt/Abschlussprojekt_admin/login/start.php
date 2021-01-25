<?php
session_start();
require "../function/connection.php";
require "../function/functions.php";

myheader();
?>

<div class="grob">
    <!-- Eine Überschrift wo man sich aktuell befindet und einem Bild.-->
    <div class="ver">
        <h1 class="hanm">Herzlich Willkommen zum Admintool für das Schwarzebrett</h1>
        <div id="bildmittig">
        <img id="blumestart" src="../pics/bunteblume.jpg">
        </div>
        
    </div>
</div>

<?php
myFooter();
?>