<?php
session_start();
ob_start();

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
    <title>Atribution Role-Intervenant</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Atribution Role-Intervenant  </h3>
              <?php   if(isset($_GET['modif']) && $_GET['modif']=='ok'){
                echo '<p style=\'color : green \'> Les rôles ont bien été attribués ! </p>';
                } ?>
                <br>
                <section>
                    <?php
                    $intervenant = $bdd ->query("select * from intervenant");
                    ?>
                    <h3 class="intervenant-rolebloc"> Liste des Intervenants : </h3>
                    <table class="tablebo">
                        <tr>
                            <th> ID </th>
                            <th> Nom </th>
                            <th> Prénom </th>
                            <th> Rôles </th>
                        </tr>
                        <?php while($intervenants = $intervenant -> fetch()){?>
                        <form id="add_role_interveant" action="gestionBoSetRoleIntervenant.php?id=<?= $intervenants['id'];?>" method="post" name="addRoleIntervenant" enctype="multipart/form-data">
                        <tr>

                            <td><?php echo $intervenants['id']; ?></td>
                            <td><?php echo $intervenants['nom']; ?></td>
                            <td><?php echo $intervenants['prenom']; ?></td>
                            <td><?php $role = $bdd->query("Select * from role");
                                while($roles = $role -> fetch()){?>

                                <div style="display: inline-block"><input style="display: block" type="checkbox" class="checkboxp" name="<?= $roles["nom_role"];?>" value="<?= $roles["id_role"];?>" <?php $checkequal = $bdd->prepare("SELECT * FROM role_intervenant WHERE id_role = ? and id_intervenant = ? " );
                                    $checkequal->execute(array($roles["id_role"],$intervenants["id"]));
                                    $count=$checkequal->fetch();
                                    if ($count != null){
                                        echo "checked";
                                    }?>><?php echo $roles["nom_role"]?></input> |</div>

                                <?php }?></td>
                            <td> <input class="submitRoleIntervantion" type="submit" name="valider_role_intervenant_bo" value="Valider"> </td>
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