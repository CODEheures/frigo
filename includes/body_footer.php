<?php
$lien1 = "/remplir.php";
$icon1 = "icon-enter";
$p1 = "Remplir mon frigo";

$lien2 = "/vider.php";
$icon2 = "icon-exit";
$p2 = "Vider mon frigo";

$lien3 = "/index.php";
$icon3 = "icon-home";
$p3 = "Accueil";

if($currentFileName == 'index.php' || $currentFileName == 'backCategorie.php' || $currentFileName == 'backAliments.php'){
    $href1 = $lien1;
    $class1 = $icon1;
    $txt1 = $p1;
    $href2 = $lien2;
    $class2 = $icon2;
    $txt2 = $p2;
} elseif ($currentFileName == 'remplir.php') {
    $href1 = $lien3;
    $class1 = $icon3;
    $txt1 = $p3;
    $href2 = $lien2;
    $class2 = $icon2;
    $txt2 = $p2;
} elseif ($currentFileName == 'vider.php') {
    $href1 = $lien1;
    $class1 = $icon1;
    $txt1 = $p1;
    $href2 = $lien3;
    $class2 = $icon3;
    $txt2 = $p3;
}
?>
<nav class="footer">
    <a href="<?php echo($href1); ?>" class="left">
        <div class="btn">
            <p><span class="<?php echo($class1); ?>"></span></p>

            <p><?php echo($txt1); ?></p>
        </div>
    </a>
    <a href="<?php echo($href2); ?>" class="right">
        <div class="btn">
            <p><span class="<?php echo($class2); ?>"></span></p>

            <p><?php echo($txt2); ?></p>
        </div>
    </a>
</nav>