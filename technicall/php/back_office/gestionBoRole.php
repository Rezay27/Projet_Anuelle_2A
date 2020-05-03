<?php
session_start();
ob_start();

include('../include/connect_bdd.php');

if(isset($_POST['Modifier'])) {

    if (isset($_GET['id'])) {
        $id = $_GET ['id'];

        $nom = htmlspecialchars($_POST['nomrole']);

        $update = $bdd->prepare('update role set nom_role = ? where id_role = ? ');
        $update->execute(array($nom, $id));

        header('Location: gestionBoRole.php?modif=ok');

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
    <title>Gestion Role BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Gestion des roles  </h3>
                <?php   if(isset($_GET['modif']) && $_GET['modif']=='ok'){
                    echo '<p style=\'color : green \'> Le role à bien été modifié ! </p>';
                } ?>
                <section  class="rolebloc">
                    <form id="add_role_bo" action="verifaddrolebo.php" name="addrolebo" method="post" enctype="multipart/form-data">
                        <h3> Ajouter un role : </h3>
                        <label > Nom du role</label>
                        <input type="text" name="nom_role" placeholder="Nom du role"/>
                        <input class="submitrole" type="submit" name="valider_role_bo" value="Ajouter le role">
                    </form>
                </section>
                <br>
                <section>
                    <?php
                    $role = $bdd ->query("select * from role");
                    ?>
                    <h3 class="rolebloc"> Liste des services : </h3>
                    <table class="tablebo">
                        <tr>
                            <th> Nom du role</th>
                            <th> Supprimer</th>
                            <th> Modifier</th>
                        </tr>
                        <?php while($roles = $role -> fetch()){?>
                            <form action="gestionBoRole.php" method="post">
                                <tr>
                                    <td><input name="nomrole" type="text" class="modifie" value="<?php echo $roles['nom_role']; ?>"></td>
                                    <td><a href="gestionBoRole.php?id_role=<?= $roles['id_role'];?>"> Supprimer </a></td>
                                    <?php if(isset($_GET['id_role'])AND !empty($_GET['id_role'])) {
                                        $id = htmlspecialchars((int)$_GET['id_role']);
                                        $supprimer = $bdd -> prepare("delete from role where id_role = ?");
                                        $supprimer -> execute(array($id));
                                        header("Location:gestionBoRole.php");
                                    }
                                    ?>
                                    <td> <input formaction="gestionBoRole.php?id=<?= $roles['id_role'];?>" type="submit"  name="Modifier" value="Modifier *"> </td>
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
