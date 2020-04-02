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
    <link href="../../css/css.css" rel="stylesheet">
    <title>Gestion Services BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Gestion des services  </h3>
                <section  class="servicebloc">
                    <form id="add_service_bo" action="verifaddservicebo.php" name="addservicebo" method="post" enctype="multipart/form-data">
                        <h3> Ajouter un service : </h3>
                        <label > Nom du service</label>
                        <input type="text" name="nom_service" placeholder="Nom du service"/>
                        <label > Prix du service</label>
                        <input  type="number" name="prix_service" placeholder="Prix du Service"/>
                        <label> Type du Service </label>
                        <?php
                        $nom_type = $bdd->query('SELECT * FROM `type_service` GROUP BY nom_type');
                        ?>
                        <select name="type_services">
                            <option value="">Selectionner une valeur </option>
                            <?php while($nom_types = $nom_type -> fetch()){?>
                                <option value="<?php echo $nom_types['id_type'];?>"><?php echo $nom_types['nom_type'];?></option>
                            <?php } ?>
                        </select>
                        <input class="submitservice" type="submit" name="valider_service_bo" value="Ajouter le service">
                    </form>
                </section>
                <section>
                    <?php
                    $service = $bdd ->query("select * from services");
                    ?>
                    <h3 class="servicebloc"> Liste des services : </h3>
                    <table>
                        <tr>
                            <th> Nom du service</th>
                            <th> Prix du service</th>
                            <th> Type de service</th>
                            <th> Supprimer</th>
                        </tr>
                        <?php while($services = $service -> fetch()){?>
                        <tr>
                            <td><?php echo $services['nom_service']; ?></td>
                            <td><?php echo $services['tarif']; ?> €</td>
                            <?php
                            $type = $bdd -> prepare('select * from type_service where id_type = ? ');
                            $type ->execute(array($services['id_type_service']));
                            $types = $type ->fetch();
                            ?>
                            <td><?php echo $types['nom_type']; ?></td>
                            <td><a href="gestionBoService.php?id_service=<?= $services['id_services'];?>"> Supprimer </a></td>
                            <?php if(isset($_GET['id_service'])AND !empty($_GET['id_service'])) {
                                $id = htmlspecialchars((int)$_GET['id_service']);
                                $supprimer = $bdd -> prepare("delete from services where id_services = ?");
                                $supprimer -> execute(array($id));
                                header("Location:gestionBoService.php");


                            }
                                ?>
                        </tr>
                        <?php } ?>
                    </table>


                </section>
        </div>
    </section>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>