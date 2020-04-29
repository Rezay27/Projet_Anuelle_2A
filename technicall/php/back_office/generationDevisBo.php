<?php

use Spipu\Html2Pdf\Html2Pdf;

require_once "../../vendor/autoload.php";
require('../include/connect_bdd.php');

session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");


$id = htmlspecialchars($_POST['id']);
$devis = htmlspecialchars($_POST['devis']);
$nom = htmlspecialchars($_POST['nom']);
$nb_heure = htmlspecialchars($_POST['nb_heure']);
$t_horaire = htmlspecialchars($_POST['t_horaire']);
$prix_mod = htmlspecialchars($_POST['prix']);

$nomadd = ($_POST['nomadd']);
$quantiteadd = $_POST['addquantite'];
$t_horaireadd = $_POST['addthoraire'];
$prix_tadd = $_POST['addprixt'];


$demande = $bdd->prepare('select * from demandes where id_demandes = ? ');
$demande->execute(array($id));
$demandes = $demande->fetch();

$total = htmlspecialchars($_POST['total']);
$prix_ht = $total / 1.2;
$tva = $total - $prix_ht;

$id_membre = $demandes['id_membre'];
$abonnement = $bdd->prepare("select * from abonnement_test where id_membre = ? ");
$abonnement->execute(array($id_membre));
$abonnement_exist = $abonnement->fetch();

$membres = $bdd->prepare('select * from membre where id_membre = ? ');
$membres->execute(array($id_membre));
$membre = $membres->fetch();

if (isset($abonnement_exist['id_membre'])) {
    $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , point_unite = ? , point_demande = ?,ref_devis=? where id_demandes = ? ");
    $modif_info->execute(array($nom, $nb_heure, $t_horaire, $prix_mod,$devis, $id));
} else {
    $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , taux_horaire = ? , prix_demande = ?,ref_devis = ? where id_demandes = ? ");
    $modif_info->execute(array($nom, $nb_heure, $t_horaire, $prix_mod,$devis, $id));
}

foreach ($nomadd as $key => $nom) {
    $key2 = $key;
    $key3 = $key;
    $key4 = $key;
    $quantite = $quantiteadd[$key2];
    $thoraire = $t_horaireadd[$key3];
    $prixadd = $prix_tadd[$key4];

if (isset($abonnement_exist['id_membre'])) {

    $insertinfisup = $bdd->prepare('insert into demandes(id_membre,nom_demande,nb_heure,point_unite,point_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,ref_devis) value (:id_membre,:nom_demande,:nb_heure,:point_unite,:point_demande,:type_demande,:date_demande,:heure,:ville,:code_postal,:adresse,:statut_demande,:ref_devis)');
    $insertinfisup->execute(array(
        "id_membre" => $demandes['id_membre'],
        "nom_demande" => $nom,
        "nb_heure" => $quantite,
        "point_unite" => $thoraire,
        "point_demande" => $prixadd,
        "type_demande" => 'perso',
        "date_demande" => $demandes['date_demande'],
        "heure" => $demandes['heure'],
        "ville" => $demandes['ville'],
        "code_postal" => $demandes['code_postal'],
        "adresse" => $demandes['adresse'],
        "statut_demande" => 0,
        "ref_devis" => $devis
    ));
}else {
    $insertinfisup = $bdd->prepare('insert into demandes(id_membre,nom_demande,nb_heure,taux_horaire,prix_demande,type_demande,date_demande,heure,ville,code_postal,adresse,statut_demande,ref_devis) value (:id_membre,:nom_demande,:nb_heure,:taux_horaire,:prix_demande,:type_demande,:date_demande,:heure,:ville,:code_postal,:adresse,:statut_demande,:ref_devis)');
    $insertinfisup->execute(array(
        "id_membre" => $demandes['id_membre'],
        "nom_demande" => $nom,
        "nb_heure" => $quantite,
        "taux_horaire" => $thoraire,
        "prix_demande" => $prixadd,
        "type_demande" => 'perso',
        "date_demande" => $demandes['date_demande'],
        "heure" => $demandes['heure'],
        "ville" => $demandes['ville'],
        "code_postal" => $demandes['code_postal'],
        "adresse" => $demandes['adresse'],
        "statut_demande" => 0,
        "ref_devis" => $devis
    ));
}
}

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
    .35p{
        width: 35%;
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
                    <?php echo $membre['prenom'].' '. $membre['nom']  ?></strong><br/>
                <?php echo nl2br($membre['adresse'] . '-' . $membre['code_postal'] . '<br>' . $membre['ville']); ?>
                <br/>
            </td>
        </tr>
    </table>
    <table style="margin-top: 50px;">
        <tr>
            <td class="50p"><h2>Devis n° </h2></td>
            <td class="50p" style="text-align: right;">Emis le <?php echo $date; ?></td>
        </tr>
    </table>

    <table style="margin-top: 30px;" class="border">
        <thead>
        <tr>
            <th class="35p">Description</th>
            <th class="35p">Nombre d'heure/Quantité</th>
            <?php if (isset($abonnement_exist['id_membre'])) { ?>
                <th class="15p"> Nombre de point (/u)</th>
            <?php } else { ?>
                <th class="15p">Prix Unitaire</th>
            <?php } ?>
            <th class="15p">Montant</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $nom ?></td>
            <td><?php echo $nb_heure; ?> </td>
            <?php if (isset($abonnement_exist['id_membre'])) { ?>
                <td><?php echo $t_horaire ?> points/u</td>
            <?php } else { ?>
                <td><?php echo $t_horaire ?> €/h</td>
            <?php }
            if (isset($abonnement_exist['id_membre'])) { ?>
                <td><?php echo $prix_mod; ?> points</td>
            <?php } else { ?>
                <td><?php echo $prix_mod; ?> €</td>
            <?php } ?>
        </tr>

        <?php foreach ($nomadd as $key => $nom) {
            $key2 = $key;
            $key3 = $key;
            $key4 = $key;
            $quantite = $quantiteadd[$key2];
            $thoraire = $t_horaireadd[$key3];
            $prixadd = $prix_tadd[$key4]; ?>
            <tr>
                <td><?php echo $nom; ?></td>
                <td><?php echo $quantite; ?></td>
                <?php if (isset($abonnement_exist['id_membre'])) { ?>
                <td><?php echo $thoraire; ?> points</td>
                <?php } else { ?>
                    <td><?php echo $thoraire; ?> €/h</td>
                <?php } ?>
                <?php if (isset($abonnement_exist['id_membre'])) { ?>
                    <td><?php echo $prixadd; ?> points</td>
                <?php } else { ?>
                    <td><?php echo $prixadd; ?> €</td>
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
                <td id="total">Total : <?php echo $total; ?> points</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
                <td id="ht">HT : <?php echo round($prix_ht, 2); ?> €</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td id="tva">TVA : <?php echo round($tva, 2) ?> €</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td id="total">TTC : <?php echo $total ?> €</td>
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
    $pdf->output($devis, 'D');
    $pdf->output('D:\wamp64\www\technicall\images\DevisPerso\ ' . $devis, 'F');
} catch (HTML2PDF_exception $e) {
    die($e);
} ?>


