<?php

use Spipu\Html2Pdf\Html2Pdf;
require_once "../../vendor/autoload.php";
require('../include/connect_bdd.php');
require_once "configPay.php";

session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");


if(isset($_POST['savedemandepoint'])){
    $tableau = htmlspecialchars($_POST['tableau_demande']);
    $tableau1 = explode('-', $tableau);

    $point_total = end($tableau1);

    $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
    $abonnement ->execute(array($_SESSION['id']));
    $abonnement_exist = $abonnement ->fetch();

    $newpoint = $abonnement_exist['nb_point'] - $point_total;


    $adresse = htmlspecialchars($_POST['adresse']);
    $ville = htmlspecialchars($_POST['ville']);
    $cp = htmlspecialchars($_POST['cp']);
    $date_demande = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['heure']);
    $description = htmlspecialchars($_POST['description']);
    $devis = htmlspecialchars($_POST['devis']);
    $facture = htmlspecialchars($_POST['facture']);

    if($newpoint < 0){

        header('Location: DemandeService.php?ok=nbpointneg');

    }else {

        for ($i = 0; $i < sizeof($tableau1) - 1; $i++) {
            $name = $tableau1[$i];
            $i++;
            $nb_heure = $tableau1[$i];
            $i++;
            $taux_h = $tableau1[$i];
            $i++;
            $prix_t = $tableau1[$i];

            $selectidservice =$bdd ->prepare('select id_services from services where nom_service = ?');
            $selectidservice->execute(array($name));
            $selectidservices=$selectidservice->fetch();

            $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,point_unite,point_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande,ref_devis,ref_facture,id_service) values (:id_membre,:nom,:nb_heure,:point_unite,:point_demande,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant,:devis ,:facture,:id_service)');
            $insert->execute(array(
                "id_membre"=>$_SESSION['id'],
                "nom" => $name,
                "nb_heure" => $nb_heure,
                "point_unite" => $taux_h,
                "point_demande" => $prix_t,
                "type_demande" => 'simple',
                "date_demande" => $date_demande,
                "heure" => $time,
                "ville" => $ville,
                "cp" => $cp,
                "adresse" => $adresse,
                "statue" => 0,
                "intervenant" => NULL,
                "devis" => $devis,
                "facture"=> $facture,
                "id_service" => $selectidservices['id_services']

            ));

            $update_point = $bdd->prepare("UPDATE abonnement_test set nb_point = ? WHERE id_membre = ?  ");
            $update_point->execute(array($newpoint, $_SESSION['id']));
        }
        header('Location:facture_pdf.php?tableau='.$tableau);
       // header('Location:DemandeService.php?ok=sucess&&tableau='.$tableau);


    }
}else {
    \Stripe\Stripe::setVerifySslCerts(false);

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
    $productID = $_GET['id'];

    if (!isset($_POST['stripeToken'])) {
        header("Location: DemandeService.php");
        exit();
    }

    $token = $_POST['stripeToken'];
    $email = $_POST["stripeEmail"];


    $tableau = htmlspecialchars($_POST['tableau_demande']);
    $tableau1 = explode('-', $tableau);

    $prix_total = end($tableau1);


    $charge = \Stripe\Charge::create(array(
        "amount" => $prix_total * 100,
        "currency" => "usd",
        "description" => "descri",
        "source" => $token,
    ));


    $adresse = htmlspecialchars($_POST['adresse']);
    $ville = htmlspecialchars($_POST['ville']);
    $cp = htmlspecialchars($_POST['cp']);
    $date_demande = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['heure']);
    $description = htmlspecialchars($_POST['description']);
    $devis = htmlspecialchars($_POST['devis']);
    $facture = htmlspecialchars($_POST['facture']);




    for ($i = 0; $i < sizeof($tableau1) - 1; $i++) {
        $name = $tableau1[$i];
        $i++;
        $nb_heure = $tableau1[$i];
        $i++;
        $taux_h = $tableau1[$i];
        $i++;
        $prix_t = $tableau1[$i];

        $selectidservice =$bdd ->prepare('select id_services from services where nom_service = ?');
        $selectidservice->execute(array($name));
        $selectidservices=$selectidservice->fetch();

        $insert = $bdd->prepare('insert into demandes (id_membre,nom_demande,nb_heure,taux_horaire,prix_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,id_intervenant_demande,ref_devis,ref_facture,id_service) values (:id_membre,:nom,:nb_heure,:taux_horaire,:prix_demandes,:type_demande,:date_demande,:heure,:ville,:cp,:adresse,:statue,:intervenant,:devis,:facture ,:id_service)');
        $insert->execute(array(
            "id_membre" => $_SESSION['id'],
            "nom" => $name,
            "nb_heure" => $nb_heure,
            "taux_horaire" => $taux_h,
            "prix_demandes" => $prix_t,
            "type_demande" => 'simple',
            "date_demande" => $date_demande,
            "heure" => $time,
            "ville" => $ville,
            "cp" => $cp,
            "adresse" => $adresse,
            "statue" => 0,
            "intervenant" => NULL,
            "devis" => $devis,
            "facture" => $facture,
            "id_service"=>$selectidservices['id_services']
        ));

        header('Location:facture_pdf.php?tableau='.$tableau);

    }
}
$tableau = htmlspecialchars($_GET['tableau']);
$tableau1 = explode('-', $tableau);

$numero_d = $bdd -> prepare('select id_demandes from demandes  group by ref_devis  order by id_demandes DESC LIMIT 0, 1');
$numero_d ->execute(array());
$last_devis = $numero_d -> fetch();
$last_devis = $last_devis['id_demandes'];


$prix_total = end($tableau1);
$prix_ht = $prix_total / 1.2;
$tva = $prix_total - $prix_ht;

$membre = $bdd->prepare("select * from membre where id_membre = ?");
$membre->execute(array($_SESSION['id']));
$membre_info = $membre->fetch();

$abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
$abonnement ->execute(array($_SESSION['id']));
$abonnement_exist = $abonnement ->fetch();

    ?>
    <style type="text/css">
        table {
            width: 100%;
            color: #717375;
            font-family: helvetica;
            line-height: 5mm;
            border-collapse: collapse;
        }

        h2 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 5px;
        }

        .border th {
            border: 1px solid #000;
            color: white;
            background: #000;
            padding: 5px;
            font-weight: normal;
            font-size: 14px;
            text-align: center;
        }

        .border td {
            border: 1px solid #CFD1D2;
            padding: 5px 10px;
            text-align: center;
        }

        .no-border {
            border-right: 1px solid #CFD1D2;
            border-left: none;
            border-top: none;
            border-bottom: none;
        }

        .space {
            padding-top: 250px;
        }

        .10p {
               width: 10%;
           }

        .15p {
               width: 15%;
           }

        .25p {
               width: 25%;
           }

        .50p {
               width: 50%;
           }

        .60p {
               width: 60%;
           }

        .75p {
               width: 75%;
           }
    </style>
    <page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">
        <page_footer>
            <hr/>
            <p>Fait a Paris, le <?php echo $date; ?></p>
            <p>Signature du particulier, suivie de la mension manuscrite "bon pour accord".</p>
        </page_footer>

        <table style="vertical-align: top;">
            <tr>
                <td class="75p">
                    <strong><?php echo 'Technicall' ?></strong><br/>
                    <?php echo '25 rue des pains 75000 <br> Paris' ?><br/>
                    <?php echo '02.35.12.43.27' ?>
                </td>
                <td class="25p">
                    <strong>
                        <?php echo $membre_info['prenom'] . " " . $membre_info['nom']; ?></strong><br/>
                    <?php echo nl2br($membre_info['adresse'] . '-' . $membre_info['code_postal'] . '<br>' . $membre_info['ville']); ?>
                    <br/>
                </td>
            </tr>
        </table>
        <table style="margin-top: 50px;">
            <tr>
                <td class="50p"><h2>Devis n° <?php echo $last_devis; ?> </h2></td>
                <td class="50p" style="text-align: right;">Emis le <?php echo $date; ?></td>
            </tr>
        </table>

        <table style="margin-top: 30px;" class="border">
            <thead>
            <tr>
                <th class="60p">Description</th>
                <th class="10p">Quantité</th>
                <?php if (isset($abonnement_exist['id_membre'])) { ?>
                    <th class="15p"> Nombre de point (/u)</th>
                <?php } else { ?>
                    <th class="15p">Prix Unitaire</th>
                <?php } ?>
                <th class="15p">Montant</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < sizeof($tableau1) - 1; $i++) { ?>
                <tr>
                    <td><?php echo $tableau1[$i]; ?></td>
                    <?php $i++; ?>
                    <td><?php echo $tableau1[$i]; ?> h</td>
                    <?php $i++;
                    if (isset($abonnement_exist['id_membre'])) { ?>
                        <td><?php echo $tableau1[$i] ?> points/u</td>
                    <?php } else { ?>
                        <td><?php echo $tableau1[$i] ?> €/h</td>
                    <?php }
                    $i++;
                    if (isset($abonnement_exist['id_membre'])) { ?>
                        <td><?php echo $tableau1[$i]; ?> points</td>
                    <?php } else { ?>
                        <td><?php echo $tableau1[$i]; ?> €</td>
                    <?php } ?>
                </tr>
            <?php } ?>

            <tr>
                <td class="space"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php if (isset($abonnement_exist['id_membre'])) { ?>
                <tr>
                    <td colspan="2" class="no-border"></td>
                    <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
                    <td>Total : <?php echo $prix_total; ?> points</td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="2" class="no-border"></td>
                    <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
                    <td>HT : <?php echo round($prix_ht, 2); ?> €</td>
                </tr>
                <tr>
                    <td colspan="2" class="no-border"></td>
                    <td>TVA : <?php echo round($tva, 2) ?> €</td>
                </tr>
                <tr>
                    <td colspan="2" class="no-border"></td>
                    <td>TTC : <?php echo $prix_total ?> €</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </page>
    <?php
    $content = ob_get_clean();
    try {
        $pdf = new HTML2PDF("p", "A4", "fr");
        $pdf->pdf->SetAuthor('Technicall');
        $pdf->pdf->SetTitle('Devis');
        $pdf->pdf->SetSubject('Achats de services');
        $pdf->pdf->SetKeywords('HTML2PDF, Devis, PHP');
        $pdf->writeHTML($content);
        $pdf->output('devis'. $last_devis. '-'. $date.'.pdf','D');
        $pdf->output('D:\wamp64\www\technicall\images\Devis\Devis'. $last_devis. '-'. $date .'.pdf','F');
    } catch (HTML2PDF_exception $e) {
        die($e);
    }?>

