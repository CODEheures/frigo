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

if(isset($_POST['categorie_delete']) && (int)$_POST['categorie_delete'] > 0){
    $db->delCategory((int)$_POST['categorie_delete']);
};

if(isset($_POST['categorie_add'])){
    $db->addCategory($_POST['categorie_add']);
};

?>
<body>

<div class="container">
    <?php include('./includes/body_header.php') ?>

    <?php include('./includes/body_nav.php') ?>


    <section class="main">
        <div class="back-categorie1">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="categorie">Choisir une catégorie</label>
                    <select name="categorie_delete" id="categorie">
                        <?php
                            $categories = $db->getCategories();
                            foreach($categories as $category){
                                echo '<option value="'. $category->idCategorie .'">'.$category->nom.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Supprimer">
            </form>
        </div>
        <div class="back-categorie2">
            <form about="#" method="post">
                <div class="form-group">
                    <label for="name">Ajouter une catégorie</label>
                    <input name="categorie_add" type="text" id="name" placeholder="dessert">
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