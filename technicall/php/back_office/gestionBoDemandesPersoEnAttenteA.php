<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
if (isset($_POST['Modifier'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $point = $_GET['point'];

        $nom = htmlspecialchars($_POST['nom']);
        $nb_heure = htmlspecialchars($_POST['nb_heure']);
        $unite = htmlspecialchars($_POST['unite']);
        $prix = htmlspecialchars($_POST['total']);

        if ($point == 1) {
            $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , point_unite = ? , point_demande = ? where id_demandes = ? ");
            $modif_info->execute(array($nom, $nb_heure, $unite, $prix, $id));
        } else {
            $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , taux_horaire = ? , prix_demande = ? where id_demandes = ? ");
            $modif_info->execute(array($nom, $nb_heure, $unite, $prix, $id));
        }
        header('Location:gestionBoDemandesPerso.php?modif=ok');

    }

}
$perso = $bdd->query("select id_demandes from demandes where statut_demande = 0 AND id_intervenant_demande is null AND type_demande='perso' AND ref_devis is null and date_demande > now() and refuser = 0");
$nb_perso = $perso->rowCount();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link href="../../css/css.css" rel="stylesheet">

    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section class="bloc1BO">
            <h3> Demandes Personnalisé en attente d'affectation
                <span class="deroulelisteperso">
                    <select onChange='change(this)' class='selectperso'>
           <option value"">Choisir une page</option>
             <option value='gestionBoDemandesPerso.php'>Demandes non traitées (<?php echo $nb_perso ?>) </option>
            <option value='gestionBoDemandesPersoEnAttenteC.php'>Demandes en attente de validation</option>
           <option value='gestionBoDemandesPersoEnCours.php'>Demandes en cours</option>
            </select>
                </span>
        </h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT  nom_demande,id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture,statut_devis from demandes where statut_demande = 0 AND type_demande = 'perso'  AND id_intervenant_demande is null  and refuser = 0 and ref_devis is not null and statut_devis=1 and date_demande > now()group by ref_devis ");

            if (isset($demandes['prix_demande'])) {
                $point = 0;
            } else {
                $point = 1;
            }
            ?>
            <table class="tablebo">
                <thead>
                <tr>
                    <th> Demande n°</th>
                    <th> Demandeur</th>
                    <th> n°devis</th>
                    <th> n° facture</th>
                    <th> Lieu</th>
                    <th> Date</th>
                    <th> Intervenant & Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr>
                        <td><input <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                   <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="text"
                                   value="<?php echo $demandes['id_demandes']; ?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                   <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td> <a href="../../images/DevisPerso/<?php echo $demandes['ref_devis']; ?>"><?php echo $demandes['ref_devis']; ?></a></td>

                        <td> <a href="../../images/FacturePerso/<?php echo $demandes['ref_facture']?>"><?php echo $demandes['ref_facture']; ?></a></td>

                        <td><input <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                   <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="text"
                                   value="<?php echo $demandes['adresse'] ?>"><input
                                <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="text"
                                value="<?php echo $demandes['ville'] ?>"><input
                                <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="text"
                                value="<?php echo $demandes['code_postal'] ?>"></td>
                        <td><input <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                   <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="date"
                                   value="<?php echo $demandes['date_demande'] ?>"><input
                                <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                                <?php } else { ?>style="color:red;" <?php } ?> class="modifie" type="time"
                                value="<?php echo $demandes['heure'] ?>"></td>
                        </td>
                        <td>
                            <a <?php if ($demandes['statut_devis'] == 1){ ?>style="color:green;"
                               <?php } else { ?>style="color:red;" <?php } ?>
                               href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                               class="popupinfo"> Intervenant & Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>