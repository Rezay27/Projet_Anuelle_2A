<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');

if(isset($_POST['Modifier'])) {

    if (isset($_GET['id'])) {
        $id = $_GET ['id'];

        $nom = htmlspecialchars($_POST['nomservice']);
        $prix = htmlspecialchars($_POST['prixservice']);

        $update = $bdd->prepare('update services set nom_service = ? ,tarif = ? where id_services = ? ');
        $update->execute(array($nom, $prix, $id));

        header('Location: gestionBoService.php?modif=ok');

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
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
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
              <?php   if(isset($_GET['modif']) && $_GET['modif']=='ok'){
                echo '<p style=\'color : green \'> Le Service à bien été modifié ! </p>';
                } ?>
                <section  class="servicebloc">
                    <form id="add_service_bo" action="verifaddservicebo.php" name="addservicebo" method="post" enctype="multipart/form-data">
                        <h3> Ajouter un service : </h3>
                        <label > Nom du service</label>
                        <input type="text" name="nom_service" placeholder="Nom du service"/>
                        <label > Prix du service</label>
                        <input  type="number" name="prix_service" placeholder="Prix du Service"/>
                        <input class="submitservice" type="submit" name="valider_service_bo" value="Ajouter le service">
                    </form>
                </section>
                <br>
                <section>
                    <?php
                    $service = $bdd ->query("select * from services");
                    ?>
                    <h3 class="servicebloc"> Liste des services : </h3>
                    <table class="tablebo">
                        <tr>
                            <th> Nom du service</th>
                            <th> Prix du service</th>
                            <th> Supprimer</th>
                            <th> Modifier</th>
                        </tr>
                        <?php while($services = $service -> fetch()){?>
                        <form action="gestionBoService.php" method="post">
                        <tr>
                            <td><input name="nomservice" type="text" class="modifie" value="<?php echo $services['nom_service']; ?>"></td>
                            <td><input name="prixservice" type="number" class="modifie" value="<?php echo $services['tarif']; ?>"> €</td>
                            <td><a href="gestionBoService.php?id_service=<?= $services['id_services'];?>"> Supprimer </a></td>
                            <?php if(isset($_GET['id_service'])AND !empty($_GET['id_service'])) {
                                $id = htmlspecialchars((int)$_GET['id_service']);
                                $supprimer = $bdd -> prepare("delete from services where id_services = ?");
                                $supprimer -> execute(array($id));
                                header("Location:gestionBoService.php");
                            }
                                ?>
                            <td> <input formaction="gestionBoService.php?id=<?= $services['id_services'];?>" type="submit"  name="Modifier" value="Modifier *"> </td>
                        </tr>
                        </form>
                        <?php } ?>
                    </table>


                </section>
        </div>
    </section>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>