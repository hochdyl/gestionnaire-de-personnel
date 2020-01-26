<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Ajouter</title>
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
        
        <?php
            if ( isset ($_GET['action'])) {
                if ($_GET['action'] == 'add') {
                    Ajouter();
                }
            }

        function Ajouter() {
            include('assets/includes/connexion.inc.php');

            $Requete = "INSERT INTO membres ( nom_mem , prenom_mem , mail_mem , statut_mem , datenaiss_mem , pays_mem , localisation_mem , dateent_mem , datesrt_mem ) 
            VALUES ( '".$_GET['nom']."' , '".$_GET['prenom']."' , '".$_GET['email']."' , '".$_GET['statut']."' , NULL , NULL , NULL , NULL , NULL );" ;

            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            if ( $_GET['statut'] == 'Stagiaire') {
                $Etp = "SELECT * FROM etapes WHERE numero_etp NOT IN (SELECT numero_etp FROM etapes WHERE numero_etp IN ('2.2','2.3'))" ;
                $ResultatEtp = mysqli_query ( $DataBase, $Etp )  or  die(mysqli_error($DataBase) ) ;


                $Mem = "SELECT id_mem FROM membres WHERE id_mem = (SELECT MAX(id_mem) FROM membres)" ;
                $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
                $LeMem = mysqli_fetch_array($ResultatMem);


                while (  $ligne = mysqli_fetch_array($ResultatEtp)  ) {
                    $AjouterEtp = "INSERT INTO situation ( mem_sit , etp_sit , datedeb_sit , datefin_sit )
                    VALUES ( ".$LeMem['id_mem']." , ".$ligne['id_etp']." , NULL , NULL )" ;
                    $Resultat = mysqli_query ( $DataBase, $AjouterEtp )  or  die(mysqli_error($DataBase) ) ;
                }
            }
            elseif ( $_GET['statut'] == 'Doctorant') {
                $Etp = "SELECT * FROM etapes WHERE numero_etp NOT IN (SELECT numero_etp FROM etapes WHERE numero_etp IN ('2.1','2.3'))" ;
                $ResultatEtp = mysqli_query ( $DataBase, $Etp )  or  die(mysqli_error($DataBase) ) ;


                $Mem = "SELECT id_mem FROM membres WHERE id_mem = (SELECT MAX(id_mem) FROM membres)" ;
                $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
                $LeMem = mysqli_fetch_array($ResultatMem);


                while (  $ligne = mysqli_fetch_array($ResultatEtp)  ) {
                    $AjouterEtp = "INSERT INTO situation ( mem_sit , etp_sit , datedeb_sit , datefin_sit )
                    VALUES ( ".$LeMem['id_mem']." , ".$ligne['id_etp']." , NULL , NULL )" ;
                    $Resultat = mysqli_query ( $DataBase, $AjouterEtp )  or  die(mysqli_error($DataBase) ) ;
                }
            }
            else {
                $Etp = "SELECT * FROM etapes WHERE numero_etp NOT IN (SELECT numero_etp FROM etapes WHERE numero_etp IN ('2.1','2.2'))" ;
                $ResultatEtp = mysqli_query ( $DataBase, $Etp )  or  die(mysqli_error($DataBase) ) ;


                $Mem = "SELECT id_mem FROM membres WHERE id_mem = (SELECT MAX(id_mem) FROM membres)" ;
                $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
                $LeMem = mysqli_fetch_array($ResultatMem);


                while (  $ligne = mysqli_fetch_array($ResultatEtp)  ) {
                    $AjouterEtp = "INSERT INTO situation ( mem_sit , etp_sit , datedeb_sit , datefin_sit )
                    VALUES ( ".$LeMem['id_mem']." , ".$ligne['id_etp']." , NULL , NULL )" ;
                    $Resultat = mysqli_query ( $DataBase, $AjouterEtp )  or  die(mysqli_error($DataBase) ) ;
                }   
            }

            $Mem = "SELECT id_mem FROM membres WHERE id_mem = (SELECT MAX(id_mem) FROM membres)" ;
            $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
            $LeMem = mysqli_fetch_array($ResultatMem);
            mkdir ("ressources/".$LeMem['id_mem']);
            
            
            $tmp_file  = 'images/unidentified.png';
            $file_name = 'avatar.jpg';
            $file_dest = "ressources/".$LeMem['id_mem'].'/'.$file_name;
            
            copy($tmp_file,$file_dest); // Mercé remzer
            
            $t = time();
            $Date=(date("Y-m-d",$t));
            
            $Requete = "INSERT INTO upload ( mem_upl , rsc_upl , nom_upl , date_upl , poid_upl ) 
            VALUES ( '".$LeMem['id_mem']."' , 1 , 'avatar' , '".$Date."' , '79.70 KB' );" ;
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;

            include('assets/includes/popup-info.inc.php');

            mysqli_close ( $DataBase ) ;
        }
        ?>
        
        <div class='maincol'>
            <div class='inner-sub'>
            
                <div class='maincol-title-container fullw'><div class='maincol-title'>Ajouter un membre</div></div>
                
                <div class='content-container fullw center'>
                    <form id='form' method='get' action='ajouter.php'> 
                        <div class='padding'><label class='form-label'>Nom</label> 
                        <input class='form-input' name='nom' type='text' required autofocus></div>
                        
                        <div class='padding'><label class='form-label'>Prénom</label> 
                        <input class='form-input' name='prenom' type='text' required></div>
                        
                        <div class='padding'><label class='form-label'>Email</label> 
                        <input class='form-input' name='email' type='mail' required></div>

                        <div class='padding'><label class='form-label'>Statut</label> 
                        <input class='form-input' list='statut' name='statut' required></div>
                                <datalist id='statut' required>
                                    <option value="ATER"></option>
                                    <option value="Doctorant"></option>
                                    <option value="Ingénieur de recherche"></option>
                                    <option value="Post-Doctorant"></option>
                                    <option value="Stagiaire" selected></option>
                                </datalist>
                        
                        <div id='send-form' class='step-icon-container flex center'><div class='step-icon-circle green'><i class="fas fa-plus step-icon"></i></div></div><input type='submit' class='hide'>
                        
                        <input type='hidden' name='action' value='add'>
                    </form>
                    
                    <?php
                if ( isset ($_GET['action'])) {
                    if ($_GET['action'] == 'add') {
                        ConsultationRapide();
                    }
                }
                
                function ConsultationRapide() {
                    include('assets/includes/connexion.inc.php');

                    $Mem = "SELECT * FROM membres WHERE id_mem = (SELECT MAX(id_mem) FROM membres)" ;
                    $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
                    $LeMem = mysqli_fetch_array($ResultatMem);
                    echo "
                    <div class='padding flex lcenter'>
                        <div class='alt-inbox-content padding flex wrap lcenter'>
                            <p class='center font-normal fullw'><span class='bold'>Démarrer</span> avec la fiche de <span class='uppercase'>".$LeMem['nom_mem']."</span> ".$LeMem['prenom_mem']."</p>       
                            <a href='consultation.php?id_mem=".$LeMem['id_mem']."'><div class='step-icon-container flex center'><div class='step-icon-circle blue'><i class='fas fa-pen step-icon'></i></div></div></a>
                        </div>
                    </div>
                    ";
                }
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