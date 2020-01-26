<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Gestionnaire du Lusac</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="HOCHET Dylan" />
    <link rel="icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="assets/css/main.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="assets/css/animations.css" type="text/css" charset="utf-8" />
    <link href="assets/css/progress-wizard.css" rel="stylesheet">
    <link href="assets/css/popup-menu.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/db8675efa8.js"></script>
    <script type="text/javascript" src="assets/js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
</head>
    
<body>
    <div class='main-content'>
        <div class='lcol'>
            <div class='inner-sub'>
                <a href='index.php'><div class='lcol-logo-container'><img src='images/lusac-white.png' class='lcol-logo'></div></a>
                <a href='index.php' class='lcol-nav padding'><i class="fas fa-home"></i></a>
                <a href='ajouter.php' class='lcol-nav padding'><i class="fas fa-plus"></i></a>
                <a href='#' class='lcol-nav padding'><i class="fas fa-cloud-download-alt"></i></a>
                <a href='#' class='lcol-nav padding'><i class="fas fa-envelope"></i></a>
                <a href='#' class='lcol-nav padding'><i class="fas fa-info"></i></a>
            </div>
        </div> 
                 
        
        <div class='maincol'>
            <div class='inner-sub'>
                <input id='search-bar' type='text' placeholder='Rechercher un membre' autofocus>
                <div class='maincol-member-container fullw'>
        
                <?php
                if ( isset ($_GET['action']) and ($_GET['action']=='delete')) {
                    include('assets/includes/popup-info.inc.php');
                }
                    
                function Consultation() {
                    include('assets/includes/connexion.inc.php');

                    $Requete = "SELECT * FROM membres ORDER BY datesrt_mem" ;

                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    
                    $Count = 0;
                    
                    while (  $ligne = mysqli_fetch_array($Resultat)  ) {
                        $Count = $Count+1;   
                    }
                    
                    if ($Count != 0) {
                        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                        while (  $ligne = mysqli_fetch_array($Resultat)  ) {
                        echo "
                            <a href='consultation.php?id_mem=".$ligne['id_mem']."' class='maincol-member padding light-bg'>
                                <div class='statute-icon'></div><div class='maincol-member-name w1-2'><span class='uppercase'>".$ligne['nom_mem']."</span> ".$ligne['prenom_mem']."</div>";
                                if ( $ligne['localisation_mem'] != "" or ( $ligne['localisation_mem'] != NULL )) {
                                    echo "<div class='maincol-member-loc w1-2 right'>Cherbourg</div>"; 
                                }
                                else {
                                    echo "<div class='maincol-member-loc w1-2 right'>Localisation non-définie</div>"; 
                                }
                        echo "</a>";
                        }
                    } else {
                        echo "<div class='padding error center font-big error-members'>Il n'y a pas de membres</div>";
                    }
                    mysqli_free_result ( $Resultat ) ;
                    mysqli_close ( $DataBase ) ;
                }
                Consultation();
                ?>
                </div>
            </div>
        </div>
        
        
        <div class='rcol'>
            <div class='inner-sub'>
                <div class='rcol-title-container'><div class='rcol-title'>Alertes</div></div>
                <div class='rcol-alerte-container'>
                    <a href='consultation.php' class='rcol-alerte attention1 padding'><div class='alerte-title'>TEST D'UNE ALERTE SUREMENT TROP LONGUE</div><div class='alerte-name'>Jérome Thiebot</div></a>
                    <a href='consultation.php' class='rcol-alerte attention2 padding'><div class='alerte-title'>Je fais des test</div><div class='alerte-name'>Ce nom est beaucoup trop long</div></a>
                    <a href='consultation.php' class='rcol-alerte attention3 padding'><div class='alerte-title'>Départ imminent</div><div class='alerte-name'>Sophie Pont</div></a>
                    <a href='consultation.php' class='rcol-alerte attention4 padding'><div class='alerte-title'>Départ dans 3 mois</div><div class='alerte-name'>Hamza</div></a>
                </div>
            </div>
        </div>
    </div>
</body>