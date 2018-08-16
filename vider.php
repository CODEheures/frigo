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
?>
<body>

<div class="container">
    <?php include('./includes/body_header.php') ?>

    <?php include('./includes/body_nav.php') ?>



    <section class="main">
        <div class="empty">
            <form action="#">
                <div class="form-group">
                    <label for="categorie">Choisir un aliment consommé</label>
                    <select name="aliment_delete" id="categorie">
                        <?php
                        $contients = $db->getContient();
                        echo '<option value=""></option>';
                        foreach($contients as $contient){
                            echo '<option value="'. $contient->idAliment .'">'. date('d/m/Y',strtotime($contient->dateFin)) . ' | ' .$contient->nom.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">et/ou chercher par date max</label>
                    <input type="text" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="01-01-2016">
                </div>
                <div class="list">
                    <ul id="list1">
                        <!-- JS IN ACTION -->
                    </ul>
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
    function remplirUl(reponse) {
        var ul = document.getElementById("list1");
        for (var un_objet_parmi in reponse) {
            var un_objet = reponse[un_objet_parmi];

            var li = document.createElement("li");
            m1 = moment();
            m2 = moment(un_objet.dateFin);

            if(m2.isBefore(m1,'day')){
                li.setAttribute("class", "passed");
            } else if (m2.isSame(m1, 'day')){
                li.setAttribute("class", "today");
            } else {
                li.setAttribute("class", "futur");
            }


            var span1 = document.createElement("span");
            span1.setAttribute("class", "name");
            span1.appendChild(document.createTextNode(un_objet.nom));

            var span2 = document.createElement("span");
            span2.setAttribute("class", "date-list");
            span2.appendChild(document.createTextNode(moment(un_objet.dateFin).format('DD-MM-YYYY')));

            var div1 = document.createElement("div");
            div1.setAttribute("class", "check-style3");

            var input1 = document.createElement("input");
            input1.setAttribute("type", "checkbox");
            input1.setAttribute("name", "aliment");
            input1.setAttribute("value", un_objet.idAliment);
            input1.setAttribute("id", "check"+un_objet.idAliment);

            var label1 = document.createElement("label");
            label1.setAttribute("for", "check"+un_objet.idAliment);

            div1.appendChild(input1);
            div1.appendChild(label1);
            li.appendChild(span1);
            li.appendChild(span2);
            li.appendChild(div1);

            ul.appendChild(li);
        }
    }


    //**********************************
    //Fonction de vidage du select ALIMENT
    //**********************************
    function viderUl() {
        var select = document.getElementById("list1");
        var child = select.lastChild;
        while (child) {
            select.removeChild(child);
            child = select.lastChild;
        }
    }


    //*****************************
    //SURVEILLANCE CHANGEMENT SELECT CATEGORIE + AJAX ALIMENT
    //*****************************
    $(function(){
        var comboday = document.getElementById("comboday");
        var combomonth = document.getElementById("combomonth");
        var comboyear = document.getElementById("comboyear");
        comboday.addEventListener("change",updateUl,false);
        combomonth.addEventListener("change",updateUl,false);
        comboyear.addEventListener("change",updateUl,false);



        function updateUl() {
            viderUl();
            var madate = document.getElementById("comboyear").value+'-';
            if (document.getElementById("combomonth").value < 9){
                madate = madate + '0'+ (parseInt(document.getElementById("combomonth").value)+1) + '-';
            } else {
                madate = madate + (parseInt(document.getElementById("combomonth").value)+1) + '-';
            }
            if (document.getElementById("comboday").value < 10){
                madate = madate + '0'+ (document.getElementById("comboday").value);
            } else {
                madate = madate + document.getElementById("comboday").value;
            }
            //madate = encodeURIComponent(madate);
            var xhr = new XMLHttpRequest;

            xhr.addEventListener('readystatechange', function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var reponse = JSON.parse(xhr.responseText);
                    remplirUl(reponse);
                }
            }, false);

            xhr.open('GET', '/ajaxListAlimentByDate.php?date=' + madate);
            xhr.send(null);
        }
    });
</script>
</body>
</html>