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
            <h3> Demandes Personnalisé non traitée</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT * FROM `demandes` where statut_demande = 0 AND type_demande = 'perso' AND ref_devis is null  ");

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
                    <th> Nom</th>
                    <th> Nombre_heure</th>
                    <th> Prix Souhaité</th>
                    <th> Date</th>
                    <th> Devis</th>
                    <th> Refuser</th>
                </tr>
    </thead>
                <?php while ($demandes = $demande->fetch()) {
                    if (isset($demandes['prix_demande'])) {
                        $point = 0;
                    } else {
                        $point = 1;
                    }
                    ?>
                    <form action="gestionBoDemandesPerso.php" method="post">
                        <tr>
                            <td><input class="modifie" type="text" name="demande"
                                       value="<?php echo $demandes['id_demandes']; ?>"></td>
                            <?php
                            $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                            $membres->execute(array($demandes['id_membre']));
                            $membre = $membres->fetch();
                            ?>
                            <td><input class="modifie" type="text"
                                       value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                            <td><input class="modifie" type="text" name="nom"
                                       value="<?php echo $demandes['nom_demande']; ?>"></td>
                            <td><input class="modifie" type="text" name="nb_heure"
                                       value="<?php echo $demandes['nb_heure']; ?>"></td>
                            <?php
                            if ($demandes['prix_demande'] !== null) { ?>
                                <td><input class="modifie" type="text" name="total"
                                           value="<?php echo $demandes['prix_demande'] ?> ">euros
                                </td>
                            <?php } else { ?>
                                <td><input class="modifie" type="text" name="total"
                                           value="<?php echo $demandes['point_demande'] ?> ">points
                                </td>
                            <?php } ?>
                            <td><input class="modifie" type="date" name="date"
                                       value="<?php echo $demandes['date_demande'] ?>"><input class="modifie"
                                                                                              type="time" name="time"
                                                                                              value="<?php echo $demandes['heure'] ?>">
                            </td>
                            <td><a href="gestionBoDevisModulable.php?demande=<?= $demandes['id_demandes'] ?>"
                                > Générer le devis </a></td>
                            <td>
                                <input formaction="gestionBoDemandesPerso.php?id=<?= $demandes['id_demandes'] . "&point=" . $point; ?>"
                                       type="submit" name="refuser" value="Refuser"></td>
                        </tr>
                    </form>
                <?php } ?>
            </table>
        </section>
        <section class="bloc1BO">
            <h3> Demandes Personnalisé en attente d'affectation (Abo)</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT  nom_demande,id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture,statut_devis,  sum(point_demande) as point_demande from demandes where statut_demande = 0 AND type_demande = 'perso' and  taux_horaire is null AND id_intervenant_demande is null and ref_devis is not null group by ref_devis ");

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
                    <th> Prix Total</th>
                    <th> Intervenant & Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr >
                        <td  ><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">
                        </td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="date" value="<?php echo $demandes['date_demande'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?>  class="modifie" type="time" value="<?php echo $demandes['heure'] ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['point_demande'] ?>  points">
                        </td>
                        <td>
                            <a <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                               class="popupinfo"> Intervenant & Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="bloc1BO">
            <h3> Demandes Personnalisé en attente d'affectation (Non Abo)</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT  id_demandes,nom_demande,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture,statut_devis, sum(prix_demande) as prix_demande from demandes where statut_demande = 0 AND type_demande = 'perso' and  taux_horaire is not null and id_intervenant_demande is null AND ref_devis is not null group by ref_devis ");
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
                    <th> Prix Total</th>
                    <th> Intervenant & Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">
                        </td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?>  class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="date" value="<?php echo $demandes['date_demande'] ?>"><input
                                <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?>  class="modifie" type="time" value="<?php echo $demandes['heure'] ?>"></td>
                        <td><input <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> class="modifie" type="text" value="<?php echo $demandes['prix_demande'] ?>  €"></td>
                        <td>
                            <a <?php if($demandes['statut_devis']==1){?>style="color:green;" <?php } else {?>style="color:red;" <?php }?> href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                               class="popupinfo"> Intervenant & Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="bloc1BO">
            <h3> Demandes Personnalisé en cours (Abo)</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT  nom_demande,id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture,statut_devis,  sum(point_demande) as point_demande from demandes where statut_demande = 0 AND type_demande = 'perso' and  taux_horaire is null AND id_intervenant_demande is not null and ref_devis is not null group by ref_devis ");

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
                    <th> Prix Total</th>
                    <th> Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr >
                        <td  ><input class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>"></td>
                        <td><input  class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">
                        </td>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                              class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                               class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                        <td><inputclass="modifie" type="date" value="<?php echo $demandes['date_demande'] ?>"><input
                                  class="modifie" type="time" value="<?php echo $demandes['heure'] ?>"></td>
                        <td><input  class="modifie" type="text" value="<?php echo $demandes['point_demande'] ?>  points">
                        </td>
                        <td>
                            <a  href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                               class="popupinfo"> Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="bloc1BO">
            <h3> Demandes en cours (Non Abo)</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT  id_demandes,nom_demande,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture,statut_devis, sum(prix_demande) as prix_demande from demandes where statut_demande = 0 AND type_demande = 'perso' and  taux_horaire is not null and id_intervenant_demande is not null AND ref_devis is not null group by ref_devis ");
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
                    <th> Prix Total</th>
                    <th> Detail</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($demandes = $demande->fetch()) { ?>
                    <tr>
                        <td><input  class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input  class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td><input class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>"></td>
                        <td><input class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">
                        </td>
                        <td><input  class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                 class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                 class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                        <td><input  class="modifie" type="date" value="<?php echo $demandes['date_demande'] ?>"><input
                                class="modifie" type="time" value="<?php echo $demandes['heure'] ?>"></td>
                        <td><input  class="modifie" type="text" value="<?php echo $demandes['prix_demande'] ?>  €"></td>
                        <td>
                            <a  href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                               class="popupinfo"> Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>