<?php

use Spipu\Html2Pdf\Html2Pdf;
require_once "../../vendor/autoload.php";
require('../include/connect_bdd.php');
require_once "configPay.php";

session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");

$devis = $_GET['devis'];
$point = $_GET['point'];
$total = $_GET['total'];
$id_membre = $_GET['id_membre'];

$prix_ht = $total / 1.2;
$tva = $total - $prix_ht;

$numero_d = $bdd -> prepare('select id_demandes from demandes  where ref_devis =? group by ref_devis');
$numero_d ->execute(array($devis));
$last_devis = $numero_d -> fetch();
$last_devis = $last_devis['id_demandes'];

$facture= 'Facture'.$last_devis.'-'. $date.'.pdf';

if($point==0){
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





$charge = \Stripe\Charge::create(array(
    "amount" => $total * 100,
    "currency" => "usd",
    "description" => "descri",
    "source" => $token,
));

$update = $bdd->prepare('update demandes set ref_facture=? , statut_devis = 1 where ref_devis =?');
$update ->execute(array($facture,$devis));

}else {

    $update = $bdd->prepare('update demandes set ref_facture=? , statut_devis = 1 where ref_devis =?');
    $update ->execute(array($facture,$devis));

    $abonnement = $bdd -> prepare("select * from abonnement_test where id_membre = ? ");
    $abonnement ->execute(array($id_membre));
    $abonnement_exist = $abonnement ->fetch();

    $newpoint = $abonnement_exist['nb_point'] - $total;

    $update_point = $bdd->prepare("UPDATE abonnement_test set nb_point = ? WHERE id_membre = ?  ");
    $update_point->execute(array($newpoint, $id_membre));

}
$membre = $bdd->prepare("select * from membre where id_membre = ?");
$membre->execute(array($id_membre));
$membre_info = $membre->fetch();


$demandes = $bdd->prepare('select * from demandes where ref_devis = ?');
$demandes ->execute(array($devis));



//header('Location: DemandeService.php?ok=payerperso');

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
            <td class="50p"><h2>Facture n° <?php echo $last_devis; ?> </h2></td>
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
        <?php while($demande = $demandes->fetch()) { ?>
            <tr>
                <td><?php echo $demande['nom_demande']; ?></td>
                <td><?php echo $demande['nb_heure']; ?> h</td>
                <?php if (isset($abonnement_exist['id_membre'])) { ?>
                    <td><?php echo $demande['point_unite'] ?> points/u</td>
                <?php } else { ?>
                    <td><?php echo $demande['taux_horaire'] ?> €/h</td>
                <?php }
                if (isset($abonnement_exist['id_membre'])) { ?>
                    <td><?php echo $demande["point_demande"]; ?> points</td>
                <?php } else { ?>
                    <td><?php echo $demande['prix_demande']; ?> €</td>
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
                <td>Total : <?php echo $total; ?> points</td>
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
                <td>TTC : <?php echo $total ?> €</td>
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
    $pdf->pdf->SetTitle('Facture');
    $pdf->pdf->SetSubject('Achats de services');
    $pdf->pdf->SetKeywords('HTML2PDF, Facture, PHP');
    $pdf->writeHTML($content);
    $pdf->output('Facture'. $last_devis. '-'. $date.'.pdf','D');
    $pdf->output('D:\wamp64\www\technicall\images\FacturePerso\Facture'. $last_devis. '-'. $date .'.pdf','F');
} catch (HTML2PDF_exception $e) {
    die($e);
}?>

<?php
?>
