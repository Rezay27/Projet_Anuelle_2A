<?php session_start(); ?>
<?php require('../include/connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");
require_once "config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/css.css">
    <style type="text/css">
        .container {
            margin-top: 100px;
        }

        .card {
            width: 300px;
            min-height: 500px;
        }

        .card:hover {
            -webkit-transform: scale(1.05);
            -moz-transform: scale(1.05);
            -ms-transform: scale(1.05);
            -o-transform: scale(1.05);
            transform: scale(1.05);
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -ms-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .list-group-item {
            border: 0px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .price {
            font-size: 72px;
        }

        .style_button {
            bottom: 10px;
            position: absolute;
            margin-left: 22%;
        }

        footer {
            margin-top : 10%;
        }
    </style>
</head>
<body>
<?php include('../include/header.php'); ?>
<div class="container">
    <?php
    $colNum = 1;
    $abonnements = $bdd->query("SELECT * from type_abonnement INNER JOIN info_abonnement ON type_abonnement.id = info_abonnement.type_abonnement ");
    $nb_abonnement = $abonnements->rowCount();
    while ($abonnement = $abonnements->fetch()) {
        $nom = $bdd->prepare("select * from type_abonnement where nom = ? ");
        $nom ->execute(array($abonnement['nom']));
        $ids = $nom->fetch();
        $id = $ids['id'];

        if ($colNum == 1)
            echo '<div class="row">';

        echo '
                <div class="col-md-4" style="margin-bottom: 10px">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="price"><span class="currency">€</span>' . $abonnement['prix'] / 100 . '</h2>
                        </div>
                        <div class="card-body text-center">
                            <div class="card-title">
                                <h2>' . $abonnement['nom'] . '</h2>
                            </div>
                            <ul class="list-group">
                            ';

        echo '<li class="list-group-item">- ' . $abonnement['description1'] . '</li>';
        echo '<li class="list-group-item">- ' . $abonnement['description2'] . '</li>';
        echo '<li class="list-group-item">- ' . $abonnement['description3'] . '</li>';

        echo '
                            </ul>
                            <br>
                                                        
                            <form class="style_button" action="stripeIPN.php?id=' . $id . '" method="POST">
                              <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="' . $stripeDetails['publishableKey'] . '"
                                data-amount="' . $abonnement['prix'] . '" 
                                data-name="' . $abonnement['nom'] . '"
                                data-description="Widget"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="French">
                              </script>
                            </form>
                        </div>
                    </div>
                </div>
            ';

        if ($colNum == $nb_abonnement) {
            echo '</div><br><br>';
            $colNum = 0;
        } else
            $colNum++;
    }
    ?>
</div>
<?php include('../include/footer.php'); ?>
</body>
</html>