<?php
include_once ('./includes/init.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php
$currentFile = __FILE__;
$tempArray = explode('/',$currentFile);
foreach($tempArray as $temp){
    if(strpos($temp,'.php')){
        $currentFileName = $temp;
    }
}

include('./includes/head.php');

if(isset($_POST['aliment_delete']) && (int)$_POST['aliment_delete'] > 0){
    $db->delAliment((int)$_POST['aliment_delete']);
};

if(isset($_POST['aliment_add']) && isset($_POST['categorie_choice']) && (int)$_POST['categorie_choice'] > 0){
    $db->addAliment($_POST['aliment_add'], $_POST['categorie_choice']);
};
?>
<body>

<div class="container">
    <?php include('./includes/body_header.php') ?>

    <?php include('./includes/body_nav.php') ?>


    <section class="main">
        <div class="back-aliment1">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="aliment">Choisir un aliment</label>
                    <select name="aliment_delete" id="aliment">
                        <?php
                        $aliments = $db->getAliments();
                        foreach($aliments as $aliment){
                            echo '<option value="'. $aliment->idAliment .'">'.$aliment->nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Supprimer">
            </form>
        </div>

        <div class="back-aliment2">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="categorie_choice">Choisir une catégorie</label>
                    <select name="categorie_choice" id="categorie_choice">
                        <?php
                        $categories = $db->getCategories();
                        foreach($categories as $category){
                            echo '<option value="'. $category->idCategorie .'">'.$category->nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Ajouter un aliment</label>
                    <input name="aliment_add" type="text" id="name" placeholder="Yahourt">
                </div>
                <input type="submit" value="Ajouter">
            </form>
        </div>
    </section>

    <?php include('./includes/body_footer.php') ?>
</div>

<?php include('./includes/body_scripts.php') ?>
</body>
</html>