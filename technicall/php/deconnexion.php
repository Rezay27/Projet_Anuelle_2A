<?php
session_start();
include('connect_bdd.php');
session_destroy();
header("Location: connexion.php");

?>
