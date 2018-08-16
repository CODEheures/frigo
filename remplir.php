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

if(isset($_POST['aliment']) && (int)$_POST['aliment'] > 0){
    $db->remplir((int)$_POST['aliment'],$_POST['date']);
};
?>

<body>

<div class="container">
    <?php include('./includes/body_header.php') ?>

    <?php include('./includes/body_nav.php') ?>


    <section class="main">
        <div class="fill">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie">
                        <?php
                        $categories = $db->getCategories();
                        foreach($categories as $category){
                            echo '<option value="'. $category->idCategorie .'">'.$category->nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="aliment">Aliment</label>
                    <select name="aliment" id="aliment">
                        <?php
                        $aliments = $db->getAlimentsByCategory($categories[0]->idCategorie);
                        foreach($aliments as $aliment){
                            echo '<option value="'. $aliment->idAliment .'">'.$aliment->nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date de péremption</label>
                    <input type="text" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="01-01-2016">
                </div>
                <input type="submit" value="Valider">
            </form>
        </div>
    </section>

    <?php include('./includes/body_footer.php') ?>
</div>

<?php include('./includes/body_scripts.php') ?>

<script>
    //**********************************
    //Fonction de remplissage du select ALIMENT
    //**********************************
    function remplirSelect(reponse) {
        var select = document.getElementById("aliment");
        for (var un_objet_parmi in reponse) {
            var option = document.createElement("option");
            var un_objet = reponse[un_objet_parmi];
            option.appendChild(document.createTextNode(un_objet.nom));
            option.setAttribute("value", un_objet.idAliment);
            select.appendChild(option);
        }
    }


    //**********************************
    //Fonction de vidage du select ALIMENT
    //**********************************
    function viderSelect() {
        var select = document.getElementById("aliment");
        var child = select.lastChild;
        while (child) {
            select.removeChild(child);
            child = select.lastChild;
        }
    }


    //*****************************
    //SURVEILLANCE CHANGEMENT SELECT CATEGORIE + AJAX ALIMENT
    //*****************************
    var monselect = document.getElementById("categorie");
    monselect.addEventListener("change",afficheAliment,false);

    function afficheAliment() {
        viderSelect();
        var category = encodeURIComponent(document.getElementById("categorie").value);

        var xhr = new XMLHttpRequest;

        xhr.addEventListener('readystatechange', function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var reponse = JSON.parse(xhr.responseText);
                remplirSelect(reponse);
            }
        }, false);

        xhr.open('GET', '/ajaxListAlimentByCategorie.php?category=' + category);
        xhr.send(null);
    }
</script>
</body>
</html>