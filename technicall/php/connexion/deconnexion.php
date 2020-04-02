<?php
session_start();
include('../include/connect_bdd.php');
session_destroy();
header("Location: connexion.php");

?>
