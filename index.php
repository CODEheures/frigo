<?php
include_once ('./includes/init.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php
//Recherche du nom Fichier en 3 etapes.
//Ce nom sera mis dans une variable.
//la variable servira dans le body_footer pour faire varier
//les boutons en bas en fonction du fichier en cours de lecture
//Ex: dans index.php les 2 boutons en bas sont "ouverture | fermeture"
//    dans vider.php les 2 boutons en bas sont "accueil | fermeture"

//Etape 1: recuperation du nom du fichier courrant (ici /.../index.php)
$currentFile = __FILE__;

//Etape 2: Découpage du nom de fichier à chaque /
$tempArray = explode('/',$currentFile);

//Etape 3: recherche de la partie contenant '.php' pour injecter dans variable $currentFileName
foreach($tempArray as $temp){
    if(strpos($temp,'.php')){
        $currentFileName = $temp;
    }
}

include('./includes/head.php');
?>
<body>

<div class="container">
    <?php include('./includes/body_header.php') ?>

    <?php include('./includes/body_nav.php') ?>


    <section class="main">
        <div class="home">
            <div class="sort">
                <div class="left">
                    <a href="/" class="active">Tri par date</a>
                </div>
                <div class="right">
                    <a href="/?sort=categorie">Tri par catégories</a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="list">
                <?php
                function setLiClass($date){
                    if(strtotime($date) < strtotime('today')){
                        $liClass = 'passed';
                    } elseif(strtotime($date) == strtotime('today')){
                        $liClass = 'today';
                    } else {
                        $liClass = 'futur';
                    }
                    return $liClass;
                }

                if(isset($_GET['sort']) && $_GET['sort']==='categorie'){
                    $contents = $db->getContent(true);
                    $categorie = '';
                    foreach($contents as $k=>$item){
                        $liClass = setLiClass($item->dateFin);
                        if($item->nom_categorie != $categorie){
                            if($categorie != ''){
                                echo '</ul>';
                            }
                            echo '<h4>'. $item->nom_categorie. '</h4>';
                            echo '<ul>';
                            $categorie = $item->nom_categorie;
                        }
                        echo '<li class="'.$liClass.'"><a href="#"><span class="name">'.$item->nom_aliment.'</span><span
                        class="date-list">'.date('d/m/Y',strtotime($item->dateFin)).'</span></a></li>';
                    }
                    if($categorie != ''){
                        echo '</ul>';
                    }
                } else {
                    echo '<ul>';
                    $contents = $db->getContent(false);
                    foreach($contents as $item){
                        $liClass = setLiClass($item->dateFin);
                        echo '<li class="'.$liClass.'"><a href="#"><span class="name">'.$item->nom_aliment.'</span><span
                        class="date-list">'.date('d/m/Y',strtotime($item->dateFin)).'</span></a></li>';
                    }
                    echo '</ul>';
                }

                ?>
            </div>
        </div>
    </section>

    <?php include('./includes/body_footer.php') ?>

</div>

<?php include('./includes/body_scripts.php') ?>
</body>
</html>