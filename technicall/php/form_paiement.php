<?php session_start(); ?>
<?php require('connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>formulaire de paiement</title>
    <meta charset="utf-8">
    <link href="../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
<?php include('header.php'); ?>

    <div class="ui inverted fixed menu">
        <div class="header item"> Paiement</div>
    </div>
    <div class="ui main container">
        <form action="verif_paiement.php" class="ui form">
            <div class="field">
                <input type="text" name="name" required placeholder="Votre nom">
            </div>
            <div class="field">
                <input type="email" name="email" required placeholder="Votre email">
            </div>
            <div class="field">
                <input type="text" placeholder="Votre code de carte bleu">
            </div>
            <div class="field">
                <input type="text" placeholder="MM">
            </div>
            <div class="field">
                <input type="text" placeholder="YY">
            </div>
            <div class="field">
                <input type="text" placeholder="CVC">
            </div>
            <p>
                <button class="ui button" type="submit"> Acheter </button>
            </p>
    </form>
    </div>
<script src="https://js.stripe.com/v3/"></script>

<?php include('footer.php'); ?>
</body>
</html>
