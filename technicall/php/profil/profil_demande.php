<?php session_start(); ?>
<?php require('../include/connect_bdd.php');

$select_intervenant = $bdd->prepare('select * from membre where id_membre = ? ');
$select_intervenant->execute(array($_SESSION['id']));
$inter = $select_intervenant->fetch();

$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link rel="stylesheet" href="../../css/css.css">
</head>
<body>
<?php include('../include/header.php'); ?>
<section>
    <section class="bloc1BO">
        <section style=" text-align: center;font-size: 30px" class="navBarBO">
            <a href="profil_membre.php"> Mon profil</a>
            <a class="couleurBarre"> | </a>
            <a href="profil_demande.php">Mes demandes </a>
        </section>
    </section>
</section>
<div class="container" style="padding-top: 60px;">
    <h1 style="text-align: center;text-decoration: underline" class="page-header">Mes demandes en cours </h1>
    <div class="row">
        <?php
        $demande = $bdd->prepare("SELECT id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture FROM `demandes` where statut_demande = 0 AND id_intervenant_demande is not null and id_membre=? and date_demande > now() GROUP BY ref_devis  ");
        $demande->execute(array($id));
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
                    <td><input class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                    <?php
                    $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                    $membres->execute(array($demandes['id_membre']));
                    $membre = $membres->fetch();
                    ?>
                    <td><input class="modifie" type="text"
                               value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                    <td>
                        <a href="../../images/Devis/<?php echo $demandes['ref_devis'] ?>"><?php echo $demandes['ref_devis']; ?></a>
                    </td>
                    <td>
                        <a href="../../images/Facture/<?php echo $demandes['ref_facture'] ?>"><?php echo $demandes['ref_facture']; ?></a>
                    </td>
                    <td><input class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                    <td><input class="modifie" type="date" value="<?php echo $demandes['date_demande'] ?>"><input
                                class="modifie" type="time" value="<?php echo $demandes['heure'] ?>"></td>
                    <td>
                        <a href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&id_membre=<?= $demandes['id_membre']; ?>"
                           class="popupinfo"> Intervenant & Detail </a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="container" style="padding-top: 60px;">

            <h1 style="text-align: center;text-decoration: underline" class="page-header">Mes anciennes demandes </h1>
            <div class="row">
                <?php
                $demande = $bdd->prepare("SELECT id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture FROM `demandes` where statut_demande = 0 and id_membre=? and date_demande < now() GROUP BY ref_devis  ");
                $demande->execute(array($id));
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
                            <td><input class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                            <?php
                            $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                            $membres->execute(array($demandes['id_membre']));
                            $membre = $membres->fetch();
                            ?>
                            <td><input class="modifie" type="text"
                                       value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                            <td>
                                <a href="../../images/Devis/<?php echo $demandes['ref_devis'] ?>"><?php echo $demandes['ref_devis']; ?></a>
                            </td>
                            <td>
                                <a href="../../images/Facture/<?php echo $demandes['ref_facture'] ?>"><?php echo $demandes['ref_facture']; ?></a>
                            </td>
                            <td><input class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                        class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                        class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                            <td><input class="modifie" type="date"
                                       value="<?php echo $demandes['date_demande'] ?>"><input class="modifie"
                                                                                              type="time"
                                                                                              value="<?php echo $demandes['heure'] ?>">
                            </td>
                            <td>
                                <a href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&id_membre=<?= $demandes['id_membre']; ?>"
                                   class="popupinfo"> Intervenant & Detail </a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container" style="padding-top: 60px;">

            <h1 style="text-align: center; text-decoration: underline" class="page-header">Mes demandes refusées </h1>
            <div class="row">
                <?php
                $demande = $bdd->prepare("SELECT id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture FROM `demandes` where refuser = 1 and id_membre= ? GROUP BY ref_devis  ");
                $demande->execute(array($id));
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
                            <td><input class="modifie" type="text" value="<?php echo $demandes['id_demandes']; ?>"></td>
                            <?php
                            $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                            $membres->execute(array($demandes['id_membre']));
                            $membre = $membres->fetch();
                            ?>
                            <td><input class="modifie" type="text"
                                       value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                            <td>
                                <a href="../../images/Devis/<?php echo $demandes['ref_devis'] ?>"><?php echo $demandes['ref_devis']; ?></a>
                            </td>
                            <td>
                                <a href="../../images/Facture/<?php echo $demandes['ref_facture'] ?>"><?php echo $demandes['ref_facture']; ?></a>
                            </td>
                            <td><input class="modifie" type="text" value="<?php echo $demandes['adresse'] ?>"><input
                                    class="modifie" type="text" value="<?php echo $demandes['ville'] ?>"><input
                                    class="modifie" type="text" value="<?php echo $demandes['code_postal'] ?>"></td>
                            <td><input class="modifie" type="date"
                                       value="<?php echo $demandes['date_demande'] ?>"><input class="modifie"
                                                                                              type="time"
                                                                                              value="<?php echo $demandes['heure'] ?>">
                            </td>
                            <td>
                                <a href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&id_membre=<?= $demandes['id_membre']; ?>"
                                   class="popupinfo"> Intervenant & Detail </a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include('../include/footer.php'); ?>
</body>
</html>
