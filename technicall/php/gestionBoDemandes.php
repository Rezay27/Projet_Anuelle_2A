<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('connect_bdd.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../css/css.css" rel="stylesheet">
    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>

    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Demandes à Valider </h3>
                <?php
                $demande = $bdd ->query ("SELECT * FROM `demandes` inner join demande_service on demandes.id_demandes = demande_service.id_demande inner join services on demande_service.id_service = services.id_services where demandes.valide = 0");
                ?>
                <table>
                    <tr>
                        <th> Demande n° </th>
                        <th> Nom Intervention </th>
                        <th > Lieu </th>
                        <th> Date </th>
                        <th> Heure </th>
                        <th > Prix </th>
                        <th> Valider </th>
                        <th>Supprimer</th>
                    </tr>
                    <?php while($demandes = $demande->fetch()){ ?>
                        <tr>
                            <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                            <td > <input class="modifie" type="text" value="<?php echo $demandes['nom_demande']; ?>">  </td>
                            <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                            <td> <input class="modifie" type="date" value="<?php echo $demandes['date']?>"></td>
                            <td> <input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                            <td> <input class="modifie" type="text" value="<?php echo $demandes['prix_demande']?>"></td>
                            <td> <a href="gestionBoDemandes.php?id_demandes=<?= $demandes['id_demandes'];?>"> Valider </a></td>
                            <?php if(isset($_GET['id_demandes'])AND !empty($_GET['id_demandes'])) {
                                $id = htmlspecialchars((int)$_GET['id_demandes']);
                                    $valides_demande = $bdd -> prepare(" UPDATE demandes SET valide = ? WHERE id_demandes = ?");
                                    $valides_demande -> execute(array(1,$id));
                                    $service = $bdd -> prepare("select * from services inner join demande_service on services.id_services = demande_service.id_service inner join demandes on demande_service.id_demande = demandes.id_demandes where id_demandes = ? ");
                                    $service->execute(array($id));
                                    $id_service = $service ->fetch();
                                    $valide_service= $bdd -> prepare(" UPDATE services SET service_valide = ? WHERE id_services = ?");
                                    $valide_service -> execute(array(1,$id_service['id_services']));
                                 header("Location:gestionBOHistorique.php");
                                 }
                                ?>
                            <td><a href="gestionBoDemandes.php?id_demandes_suppr=<?= $demandes['id_demandes'];?>"> Supprimer </a></td>
                            <?php if(isset($_GET['id_demandes_suppr'])AND !empty($_GET['id_demandes_suppr'])) {
                                $id = htmlspecialchars((int)$_GET['id_demandes_suppr']);
                                $supprimer_demandes = $bdd->prepare("DELETE from demandes where id_demandes = ? ");
                                $supprimer_demandes->execute(array($id));
                                $supprimer_demandes_membre = $bdd->prepare("delete from membre_demande where id_demande = ? ");
                                $supprimer_demandes_membre->execute(array($id));
                                $service = $bdd->prepare('select * from demande_service where id_demande = ?');
                                $service->execute(array($id));
                                $services = $service->fetch();
                                $supprimer_service = $bdd->prepare('delete from services where id_services = ? ');
                                $supprimer_service->execute(array($services['id_service']));
                                $supprimer_demande_service = $bdd->prepare('delete from demande_service where id_demande = ? ');
                                $supprimer_demande_service->execute(array($id));
                                header("Location:gestionBoDemandes.php");
                            }
                            ?>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>
</body>
</html>