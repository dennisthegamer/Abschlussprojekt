<?php
    // Zunächst wird die "session" gestartet.
    session_start();
    // Daach wird sie direkt zerstört.
    session_destroy();
    // Wenn dies gemacht wurde, wird man zum "Login" weitergeleitet.
    header("Location: ../login/login.php")

?>