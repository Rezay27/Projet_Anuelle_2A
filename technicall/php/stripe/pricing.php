<?php session_start(); ?>
<?php require('../connect_bdd.php');
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
        }

        .price {
            font-size: 72px;
        }

        .currency {
            position: relative;
            font-size: 25px;
            top: -31px;
        }
    </style>
</head>
<body>
<?php include('../header.php'); ?>
<div class="container">
    <?php
        $colNum = 1;
        foreach ($products as $productID => $attributes) {
            if ($colNum == 1)
                echo '<div class="row">';

            echo '
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="price"><span class="currency">$</span>'.($attributes['price']/100).'</h2>
                        </div>
                        <div class="card-body text-center">
                            <div class="card-title">
                                <h2>'.$attributes['title'].'</h2>
                            </div>
                            <ul class="list-group">
                            ';

                            foreach($attributes['features'] as $feature)
                                echo '<li class="list-group-item">'.$feature.'</li>';

                        echo '
                            </ul>
                            <br>
                            <form action="stripeIPN.php?id='.$productID.'" method="POST">
                              <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="'.$stripeDetails['publishableKey'].'"
                                data-amount="'.$attributes['price'].'"
                                data-name="'.$attributes['title'].'"
                                data-description="Widget"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto">
                              </script>
                            </form>
                        </div>
                    </div>
                </div>
            ';

            if ($colNum == 3) {
                echo '</div><br>';
                $colNum = 0;
            } else
                $colNum++;
        }
    ?>
</div>
<?php include('../footer.php'); ?>
</body>
</html>