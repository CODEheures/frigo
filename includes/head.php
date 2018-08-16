<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro:200' rel='stylesheet' type='text/css'>
    <?php if(!isset($_SESSION['style']) || $_SESSION['style'] == 1){
        echo('<link href="/css/style.css" rel="stylesheet" type="text/css">');
    } elseif(isset($_SESSION['style']) || $_SESSION['style'] == 2) {
        echo('<link href="/css/style2.css" rel="stylesheet" type="text/css">');
    }
    ?>
    <title>Mon Frigo</title>
</head>