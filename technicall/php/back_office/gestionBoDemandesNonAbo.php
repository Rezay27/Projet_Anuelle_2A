<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link href="../../css/css.css" rel="stylesheet">

    <title>Gestion Detail d'une demande</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section  class="bloc1BO">
            <h3> Demandes en attente d'affactation (Non Abo) </h3>
            <?php
            $demande = $bdd ->query ("SELECT id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture, sum(prix_demande) as prix_demande FROM `demandes` where statut_demande = 0 AND id_intervenant_demande is null AND type_demande='simple' AND point_demande is null GROUP BY ref_devis  ");
            ?>

            <table class="tablebo">
                <thead>
                <tr>
                    <th> Demande n° </th>
                    <th> Demandeur</th>
                    <th> n°devis </th>
                    <th> n° facture</th>
                    <th > Lieu </th>
                    <th> Date </th>
                    <th> Prix Total </th>
                    <th> Intervenant & Detail </th>
                </tr>
                </thead>
                <tbody>
                <?php while($demandes = $demande->fetch()){ ?>
                    <tr >
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres ->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input class="modifie" type="text" value="<?php echo $membre["nom"] .' '. $membre['prenom']; ?>"</td>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>">  </td>
                        <td  > <input class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">  </td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                        <td> <input class="modifie" type="date" value="<?php echo $demandes['date_demande']?>"><input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['prix_demande']?>  €"></td>
                        <td> <a href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture'];?>&&id_membre=<?=$demandes['id_membre'];?>"class="popupinfo"> Intervenant & Detail </a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </section>
        <section  class="bloc1BO">
            <h3> Demandes en cours (Non Abo) </h3>
            <?php
            $demande = $bdd ->query ("SELECT id_demandes,id_membre,date_demande,heure,ville,code_postal,adresse,ref_devis,ref_facture, sum(prix_demande) as prix_demande FROM `demandes` where statut_demande = 0 AND id_intervenant_demande is not null AND type_demande='simple' AND point_demande is null GROUP BY ref_devis  ");
            ?>

            <table class="tablebo">
                <thead>
                <tr>
                    <th> Demande n° </th>
                    <th> Demandeur</th>
                    <th> n°devis </th>
                    <th> n° facture</th>
                    <th > Lieu </th>
                    <th> Date </th>
                    <th> Prix Total </th>
                    <th> Detail </th>
                </tr>
                </thead>
                <tbody>
                <?php while($demandes = $demande->fetch()){ ?>
                    <tr>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres ->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input class="modifie" type="text" value="<?php echo $membre["nom"] .' '. $membre['prenom']; ?>"</td>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['ref_devis']; ?>">  </td>
                        <td  > <input class="modifie facture" type="text" value="<?php echo $demandes['ref_facture']; ?>">  </td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                        <td> <input class="modifie" type="date" value="<?php echo $demandes['date_demande']?>"><input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['prix_demande']?>  €"></td>
                        <td> <a href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture'];?>&&id_membre=<?=$demandes['id_membre'];?>"class="popupinfo"> Detail </a></td>
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