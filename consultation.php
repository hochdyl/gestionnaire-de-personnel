<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Consultation</title>
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
                if ($_GET['action'] == 'delete') { Supprimer(); }
                if ($_GET['action'] == 'send') { Send(); }
                if ($_GET['action'] == 'skip') { Skip(); }
                if ($_GET['action'] == 'update') { Update(); }
            }
        


        function Supprimer() {
            include('assets/includes/connexion.inc.php');
            
            $dir='ressources/'.$_GET['id_mem'];
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                         RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
            
            $Requete = "DELETE FROM membres WHERE id_mem=".$_GET['id_mem'] ;
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            mysqli_close ( $DataBase ) ;
            
            header('Location: index.php?action=delete');
        }
        
        function Send() {                    

        }

        function Skip() {
            include('assets/includes/connexion.inc.php');
            $t = time();
            $Date=(date("Y-m-d",$t));

            $LeTitre = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
            $ResultatTitre = mysqli_query ( $DataBase, $LeTitre )  or  die(mysqli_error($DataBase) ) ;
            $ligneTitre = mysqli_fetch_array($ResultatTitre);

            if ( $ligneTitre['statut_mem'] == 'Stagiaire' ) {
                $Etape='3';
            } else {
            if ( $ligneTitre['statut_mem'] == 'Doctorant' ) {
                $Etape='4';
            } else {
                $Etape='5';
            }}
            
            if ($_GET['etape']=='3,4,5') {
                $Requete = "UPDATE situation SET datefin_sit='".$Date."' WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=".$Etape ;
                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            } else {
            $Requete = "UPDATE situation SET datefin_sit='".$Date."' WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=".$_GET['etape'] ;
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            }
            include('assets/includes/popup-info.inc.php');
            mysqli_close ( $DataBase ) ;
        }
        
        function Update() {
            include('assets/includes/connexion.inc.php');
            $Requete = "UPDATE membres SET 
            datenaiss_mem='".$_GET['datenaiss']."',
            pays_mem='".$_GET['pays']."',
            localisation_mem='".$_GET['localisation']."',
            dateent_mem='".$_GET['dateent']."',
            datesrt_mem='".$_GET['datesrt']."'
            WHERE id_mem=".$_GET['id_mem'] ;
            
            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
            
            include('assets/includes/popup-info.inc.php');
            mysqli_close ( $DataBase ) ;
        }
        ?>
        
        <div class='maincol'>
            <div class='inner-sub'>
                
                <div class='popup-info-visibility delete a-fadeout'>
                    <div class='popup-info-overlay'></div>
                    <div class='popup-info padding center'>
                        <label><input class='popup-info-close' type=button value='X'/></label>
                        <form id='deletemem-form'>
                            <span class='font-normal'>Êtes-vous sûr de vouloir supprimer :<br></span>
                            
                            <?php 
                                include('assets/includes/connexion.inc.php');

                                $Requete = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                                $ligne = mysqli_fetch_array($Resultat);
                                    
                                echo "<span class='bold font-normal'><span class='uppercase'>".$ligne['nom_mem']."</span> ".$ligne['prenom_mem']."</span>";
                            
                            mysqli_close ( $DataBase ) ;
                            ?>
                            

                            <div id='send-deletemem-form' class='step-icon-container flex center'><div class='step-icon-circle red'><i class="fas fa-trash step-icon"></i></div></div><input type='submit' class='hide'>
                            
                            <input type='hidden' name='id_mem' value='<?php echo $_GET['id_mem']; ?>'>
                            <input type='hidden' name='action' value='delete'>
                        </form>
                    </div>
                </div>
                
                <div class='maincol-title-container fullw'><div class='maincol-title'>Consultation</div></div>
                
                <div class='content-container fullw'>
                    
                    <?php 
                                        include('assets/includes/connexion.inc.php');


                            $LeTitre = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                            $ResultatTitre = mysqli_query ( $DataBase, $LeTitre )  or  die(mysqli_error($DataBase) ) ;
                            $ligneTitre = mysqli_fetch_array($ResultatTitre);

                            if ( $ligneTitre['statut_mem'] == 'Stagiaire' ) {
                                $Etape='3';
                                $Titre='Convention de stage';
                                $Pre='de la ';
                            } else {
                                if ( $ligneTitre['statut_mem'] == 'Doctorant' ) {
                                    $Etape='4';
                                    $Titre='Convention Doctorale';
                                    $Pre='de la ';
                                } else {
                                    $Etape='5';
                                    $Titre='Contrat de travail';
                                    $Pre='du ';
                                }
                            }

                    
                    function ProgressBar() {
                        include('assets/includes/connexion.inc.php');
                        
                        global $Etape;
                        
                        echo "
                        <ul class='progress-indicator'>";
                        
                        // VERIFICATION FORMULAIRE AGENT
                        $Situations = "SELECT * FROM situation s JOIN etapes e ON e.id_etp=s.etp_sit WHERE s.mem_sit=".$_GET['id_mem']." AND s.etp_sit=2";
                        $ResultatSituations = mysqli_query ( $DataBase, $Situations )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituations);
                        
                        if ($ligne['datefin_sit']!='' or ($ligne['datefin_sit']!=NULL)) {
                            $originalDate = $ligne['datefin_sit'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            
                            echo "<li class='completed'><span class='bubble'></span>".$ligne['nom_etp']."<br>".$newDate."</li>";
                        } else {echo "<li><span class='bubble'></span>".$ligne['nom_etp']."</li>";}
                        
                        
                        // VERIFICATION CONTRAT/CONVENTION
                        $Situations = "SELECT * FROM situation s JOIN etapes e ON e.id_etp=s.etp_sit WHERE s.mem_sit=".$_GET['id_mem']." AND s.etp_sit=".$Etape;
                        $ResultatSituations = mysqli_query ( $DataBase, $Situations )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituations);
                        
                        if ($ligne['datefin_sit']!='' or ($ligne['datefin_sit']!=NULL)) {
                            $originalDate = $ligne['datefin_sit'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            
                            echo "<li class='completed'><span class='bubble'></span>".$ligne['nom_etp']."<br>".$newDate."</li>";
                        } else {echo "<li><span class='bubble'></span>".$ligne['nom_etp']."</li>";}
                        
                        
                        // VERIFICATION PERSOPASS
                        $Situations = "SELECT * FROM situation s JOIN etapes e ON e.id_etp=s.etp_sit WHERE s.mem_sit=".$_GET['id_mem']." AND s.etp_sit=7";
                        $ResultatSituations = mysqli_query ( $DataBase, $Situations )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituations);
                        
                        if ($ligne['datefin_sit']!='' or ($ligne['datefin_sit']!=NULL)) {
                            $originalDate = $ligne['datefin_sit'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            
                            echo "<li class='completed'><span class='bubble'></span>".$ligne['nom_etp']."<br>".$newDate."</li>";
                        } else {echo "<li><span class='bubble'></span>".$ligne['nom_etp']."</li>";}
                        
                        
                        // VERIFICATION LEOCARTE
                        $Situations = "SELECT * FROM situation s JOIN etapes e ON e.id_etp=s.etp_sit WHERE s.mem_sit=".$_GET['id_mem']." AND s.etp_sit=10";
                        $ResultatSituations = mysqli_query ( $DataBase, $Situations )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituations);
                        
                        if ($ligne['datefin_sit']!='' or ($ligne['datefin_sit']!=NULL)) {
                            $originalDate = $ligne['datefin_sit'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            
                            echo "<li class='completed'><span class='bubble'></span>".$ligne['nom_etp']."<br>".$newDate."</li>";
                        } else {echo "<li><span class='bubble'></span>".$ligne['nom_etp']."</li>";}
                        
                        
                        // VERIFICATION DEPART
                        $Situations = "SELECT * FROM situation s JOIN etapes e ON e.id_etp=s.etp_sit WHERE s.mem_sit=".$_GET['id_mem']." AND s.etp_sit=11";
                        $ResultatSituations = mysqli_query ( $DataBase, $Situations )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituations);
                        
                        if ($ligne['datefin_sit']!='' or ($ligne['datefin_sit']!=NULL)) {
                            $originalDate = $ligne['datefin_sit'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            
                            echo "<li class='completed'><span class='bubble'></span>".$ligne['nom_etp']."<br>".$newDate."</li>";
                        } else {echo "<li><span class='bubble'></span>".$ligne['nom_etp']."</li>";}
                        
                        echo "</ul>";
                    
                        mysqli_close ( $DataBase ) ;
                    }
                    ProgressBar();
                 
                    
                    
                    echo "
                    <div class='flex content-container'>
                        <div class='avatar-container w1-3'>
                            <nav class='menu'>
                                <input type='checkbox' href='#' class='menu-open' name='menu-open' id='menu-open' />
                                <label class='menu-open-button' for='menu-open'>
                                    <span class='lines line-1'></span><span class='lines line-2'></span><span class='lines line-3'></span>
                                </label>
                                <a href='modifier.php?id_mem=".$_GET['id_mem']."' class='menu-item blue'><i class='fas fa-pen'></i></a>
                                <a href='avatar.php?id_mem=".$_GET['id_mem']."' class='menu-item green'><i class='fas fa-user-circle'></i></a>
                                <a href='documents.php?id_mem=".$_GET['id_mem']."' class='menu-item purple'><i class='fas fa-file-alt'></i></a>
                                <a href='#' class='menu-item red popup-info-delete-trigger'><i class='fas fa-trash'></i></a>
                            </nav>
                            <div class='avatar-upload'>
                                <div class='avatar-preview'>
                                    <div style='background-image: url(ressources/".$_GET['id_mem']."/avatar.jpg);'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='head-container vcenter padding'>
                    ";     
                            
                            $Requete = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                            $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                            $ligne = mysqli_fetch_array($Resultat);
                            
                            echo "
                            <div class='font-rbig fullw bold uppercase'>".$ligne['nom_mem']."</div>
                            <div class='font-big fullw italic'>".$ligne['prenom_mem']."</div>
                                <div class='flex spc-top'>
                                    <div class='statute-icon'></div><div class='font-normal fullw'>".$ligne['statut_mem']."</div>
                                </div>
                                <div class='flex spc-top'>";
                                    if ( $ligne['localisation_mem'] != "" or ( $ligne['localisation_mem'] != NULL )) {
                                        echo "<div class='w1-3 padding light-bg'>Localisation : ".$ligne['localisation_mem']."</div>"; 
                                    } else {
                                        echo "<div class='w1-3 padding light-bg'>Localisation : Non-définie</div>"; 
                                    }
                            
                                    if ( $ligne['dateent_mem'] != "" or ( $ligne['dateent_mem'] != NULL )) {
                                        echo "<div class='w1-3 padding light-bg'>Arrivé(e) le : ".$ligne['dateent_mem']."</div>"; 
                                    } else {
                                        echo "<div class='w1-3 padding light-bg'>Arrivé(e) le : Non-définie</div>"; 
                                    }
                                    
                                    if ( $ligne['datesrt_mem'] != "" or ( $ligne['datesrt_mem'] != NULL )) {
                                        echo "<div class='w1-3 padding light-bg'>Départ le : ".$ligne['datesrt_mem']."</div>"; 
                                    } else {
                                        echo "<div class='w1-3 padding light-bg'>Départ le : Non-définie</div>"; 
                                    }
                    
                                    echo "</div><div class='flex center'><div class='w1-2 padding light-bg'>Mail : ".$ligne['mail_mem']."</div>"; 
                    
                                    if ( $ligne['pays_mem'] != "" or ( $ligne['pays_mem'] != NULL )) {
                                        echo "<div class='w1-2 padding light-bg'>Pays : ".$ligne['pays_mem']."</div>"; 
                                    } else {
                                        echo "<div class='w1-2 padding light-bg'>Pays : Non-définie</div>"; 
                                    }
                                echo " </div>
                                    </div> 
                                </div>";
            
                    
                    
                    
                        $Complete=0;
                
                        // INFORMATIONS A VERIFIER
                        $LaSituation = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( ($ligne['datenaiss_mem'] != NULL or ( $ligne['datenaiss_mem'] != "" ))
                            and ( ($ligne['pays_mem'] != NULL or ( $ligne['pays_mem'] != "" )))
                            and ( ($ligne['localisation_mem'] != NULL or ( $ligne['localisation_mem'] != "" )))
                            and ( ($ligne['dateent_mem'] != NULL or ( $ligne['dateent_mem'] != "" )))
                            and ( ($ligne['datesrt_mem'] != NULL or ( $ligne['datesrt_mem'] != "" )))
                            )  {}
                        else {
                            $Complete=1;
                            
                            $t = time();
                            $Date=(date("Y-m-d",$t));
                            
                        echo "
                        <form id='update-info-form'>
                            <div class='flex content-container fullw' id='informations-completer'>
                                <div class='flex wrap step-container padding'>
                                    <div class='step-title-container'><div class='step-title padding'>Informations à completer</div></div><div class='after-triangle'></div>
                                    <div class='inbox-content padding flex wrap center'>
                                        <p class='center font-normal fullw spc-bottom'>Veuillez <span class='bold'>renseigner</span> les informations suivantes pour continuer</p>
                            ";   
                            
                        if ( $ligne['datenaiss_mem'] == NULL or ( $ligne['datenaiss_mem'] == "" )) {
                            echo "
                            <div class='padding'><label class='form-label'>Date de naissance</label> 
                            <input class='form-input' type='date' name='datenaiss' max='".$Date."'required></div>
                            ";
                        }
                            
                        if ( $ligne['pays_mem'] == NULL or ( $ligne['pays_mem'] == "" )) {
                            echo "
                            <div class='padding'><label class='form-label'>Pays de naissance</label>
                            <input class='form-input' list='pays' name='pays' required></div>
                                <datalist id='pays' required>
                                    <option value='Afghanistan'></option>
                                    <option value='Åland Islands'></option>
                                    <option value='Albania'></option>
                                    <option value='Algeria'></option>
                                    <option value='American Samoa'></option>
                                    <option value='Andorra'></option>
                                    <option value='Angola'></option>
                                    <option value='Anguilla'></option>
                                    <option value='Antarctica'></option>
                                    <option value='Antigua and Barbuda'></option>
                                    <option value='Argentina'></option>
                                    <option value='Armenia'></option>
                                    <option value='Aruba'></option>
                                    <option value='Australia'></option>
                                    <option value='Austria'></option>
                                    <option value='Azerbaijan'></option>
                                    <option value='Bahamas'></option>
                                    <option value='Bahrain'></option>
                                    <option value='Bangladesh'></option>
                                    <option value='Barbados'></option>
                                    <option value='Belarus'></option>
                                    <option value='Belgium'></option>
                                    <option value='Belize'></option>
                                    <option value='Benin'></option>
                                    <option value='Bermuda'></option>
                                    <option value='Bhutan'></option>
                                    <option value='Bolivia'></option>
                                    <option value='Bosnia and Herzegovina'></option>
                                    <option value='Botswana'></option>
                                    <option value='Bouvet Island'></option>
                                    <option value='Brazil'></option>
                                    <option value='British Indian Ocean Territory'></option>
                                    <option value='Brunei Darussalam'></option>
                                    <option value='Bulgaria'></option>
                                    <option value='Burkina Faso'></option>
                                    <option value='Burundi'></option>
                                    <option value='Cambodia'></option>
                                    <option value='Cameroon'></option>
                                    <option value='Canada'></option>
                                    <option value='Cape Verde'></option>
                                    <option value='Cayman Islands'></option>
                                    <option value='Central African Republic'></option>
                                    <option value='Chad'></option>
                                    <option value='Chile'></option>
                                    <option value='China'></option>
                                    <option value='Christmas Island'></option>
                                    <option value='Cocos (Keeling) Islands'></option>
                                    <option value='Colombia'></option>
                                    <option value='Comoros'></option>
                                    <option value='Congo'></option>
                                    <option value='Congo, The Democratic Republic of The'></option>
                                    <option value='Cook Islands'></option>
                                    <option value='Costa Rica'></option>
                                    <option value='Cote D'ivoire'></option>
                                    <option value='Croatia'></option>
                                    <option value='Cuba'></option>
                                    <option value='Cyprus'></option>
                                    <option value='Czech Republic'></option>
                                    <option value='Denmark'></option>
                                    <option value='Djibouti'></option>
                                    <option value='Dominica'></option>
                                    <option value='Dominican Republic'></option>
                                    <option value='Ecuador'></option>
                                    <option value='Egypt'></option>
                                    <option value='El Salvador'></option>
                                    <option value='Equatorial Guinea'></option>
                                    <option value='Eritrea'></option>
                                    <option value='Estonia'></option>
                                    <option value='Ethiopia'></option>
                                    <option value='Falkland Islands (Malvinas)'></option>
                                    <option value='Faroe Islands'></option>
                                    <option value='Fiji'></option>
                                    <option value='Finland'></option>
                                    <option value='France' selected></option>
                                    <option value='French Guiana'></option>
                                    <option value='French Polynesia'></option>
                                    <option value='French Southern Territories'></option>
                                    <option value='Gabon'></option>
                                    <option value='Gambia'></option>
                                    <option value='Georgia'></option>
                                    <option value='Germany'></option>
                                    <option value='Ghana'></option>
                                    <option value='Gibraltar'></option>
                                    <option value='Greece'></option>
                                    <option value='Greenland'></option>
                                    <option value='Grenada'></option>
                                    <option value='Guadeloupe'></option>
                                    <option value='Guam'></option>
                                    <option value='Guatemala'></option>
                                    <option value='Guernsey'></option>
                                    <option value='Guinea'></option>
                                    <option value='Guinea-bissau'></option>
                                    <option value='Guyana'></option>
                                    <option value='Haiti'></option>
                                    <option value='Heard Island and Mcdonald Islands'></option>
                                    <option value='Holy See (Vatican City State)'></option>
                                    <option value='Honduras'></option>
                                    <option value='Hong Kong'></option>
                                    <option value='Hungary'></option>
                                    <option value='Iceland'></option>
                                    <option value='India'></option>
                                    <option value='Indonesia'></option>
                                    <option value='Iran, Islamic Republic of'></option>
                                    <option value='Iraq'></option>
                                    <option value='Ireland'></option>
                                    <option value='Isle of Man'></option>
                                    <option value='Israel'></option>
                                    <option value='Italy'></option>
                                    <option value='Jamaica'></option>
                                    <option value='Japan'></option>
                                    <option value='Jersey'></option>
                                    <option value='Jordan'></option>
                                    <option value='Kazakhstan'></option>
                                    <option value='Kenya'></option>
                                    <option value='Kiribati'></option>
                                    <option value='Korea, Democratic People's Republic of'></option>
                                    <option value='Korea, Republic of'></option>
                                    <option value='Kuwait'></option>
                                    <option value='Kyrgyzstan'></option>
                                    <option value='Lao People's Democratic Republic'></option>
                                    <option value='Latvia'></option>
                                    <option value='Lebanon'></option>
                                    <option value='Lesotho'></option>
                                    <option value='Liberia'></option>
                                    <option value='Libyan Arab Jamahiriya'></option>
                                    <option value='Liechtenstein'></option>
                                    <option value='Lithuania'></option>
                                    <option value='Luxembourg'></option>
                                    <option value='Macao'></option>
                                    <option value='Macedonia, The Former Yugoslav Republic of'></option>
                                    <option value='Madagascar'></option>
                                    <option value='Malawi'></option>
                                    <option value='Malaysia'></option>
                                    <option value='Maldives'></option>
                                    <option value='Mali'></option>
                                    <option value='Malta'></option>
                                    <option value='Marshall Islands'></option>
                                    <option value='Martinique'></option>
                                    <option value='Mauritania'></option>
                                    <option value='Mauritius'></option>
                                    <option value='Mayotte'></option>
                                    <option value='Mexico'></option>
                                    <option value='Micronesia, Federated States of'></option>
                                    <option value='Moldova, Republic of'></option>
                                    <option value='Monaco'></option>
                                    <option value='Mongolia'></option>
                                    <option value='Montenegro'></option>
                                    <option value='Montserrat'></option>
                                    <option value='Morocco'></option>
                                    <option value='Mozambique'></option>
                                    <option value='Myanmar'></option>
                                    <option value='Namibia'></option>
                                    <option value='Nauru'></option>
                                    <option value='Nepal'></option>
                                    <option value='Netherlands'></option>
                                    <option value='Netherlands Antilles'></option>
                                    <option value='New Caledonia'></option>
                                    <option value='New Zealand'></option>
                                    <option value='Nicaragua'></option>
                                    <option value='Niger'></option>
                                    <option value='Nigeria'></option>
                                    <option value='Niue'></option>
                                    <option value='Norfolk Island'></option>
                                    <option value='Northern Mariana Islands'></option>
                                    <option value='Norway'></option>
                                    <option value='Oman'></option>
                                    <option value='Pakistan'></option>
                                    <option value='Palau'></option>
                                    <option value='Palestinian Territory, Occupied'></option>
                                    <option value='Panama'></option>
                                    <option value='Papua New Guinea'></option>
                                    <option value='Paraguay'></option>
                                    <option value='Peru'></option>
                                    <option value='Philippines'></option>
                                    <option value='Pitcairn'></option>
                                    <option value='Poland'></option>
                                    <option value='Portugal'></option>
                                    <option value='Puerto Rico'></option>
                                    <option value='Qatar'></option>
                                    <option value='Reunion'></option>
                                    <option value='Romania'></option>
                                    <option value='Russian Federation'></option>
                                    <option value='Rwanda'></option>
                                    <option value='Saint Helena'></option>
                                    <option value='Saint Kitts and Nevis'></option>
                                    <option value='Saint Lucia'></option>
                                    <option value='Saint Pierre and Miquelon'></option>
                                    <option value='Saint Vincent and The Grenadines'></option>
                                    <option value='Samoa'></option>
                                    <option value='San Marino'></option>
                                    <option value='Sao Tome and Principe'></option>
                                    <option value='Saudi Arabia'></option>
                                    <option value='Senegal'></option>
                                    <option value='Serbia'></option>
                                    <option value='Seychelles'></option>
                                    <option value='Sierra Leone'></option>
                                    <option value='Singapore'></option>
                                    <option value='Slovakia'></option>
                                    <option value='Slovenia'></option>
                                    <option value='Solomon Islands'></option>
                                    <option value='Somalia'></option>
                                    <option value='South Africa'></option>
                                    <option value='South Georgia and The South Sandwich Islands'></option>
                                    <option value='Spain'></option>
                                    <option value='Sri Lanka'></option>
                                    <option value='Sudan'></option>
                                    <option value='Suriname'></option>
                                    <option value='Svalbard and Jan Mayen'></option>
                                    <option value='Swaziland'></option>
                                    <option value='Sweden'></option>
                                    <option value='Switzerland'></option>
                                    <option value='Syrian Arab Republic'></option>
                                    <option value='Taiwan, Province of China'></option>
                                    <option value='Tajikistan'></option>
                                    <option value='Tanzania, United Republic of'></option>
                                    <option value='Thailand'></option>
                                    <option value='Timor-leste'></option>
                                    <option value='Togo'></option>
                                    <option value='Tokelau'></option>
                                    <option value='Tonga'></option>
                                    <option value='Trinidad and Tobago'></option>
                                    <option value='Tunisia'></option>
                                    <option value='Turkey'></option>
                                    <option value='Turkmenistan'></option>
                                    <option value='Turks and Caicos Islands'></option>
                                    <option value='Tuvalu'></option>
                                    <option value='Uganda'></option>
                                    <option value='Ukraine'></option>
                                    <option value='United Arab Emirates'></option>
                                    <option value='United Kingdom'></option>
                                    <option value='United States'></option>
                                    <option value='United States Minor Outlying Islands'></option>
                                    <option value='Uruguay'></option>
                                    <option value='Uzbekistan'></option>
                                    <option value='Vanuatu'></option>
                                    <option value='Venezuela'></option>
                                    <option value='Viet Nam'></option>
                                    <option value='Virgin Islands, British'></option>
                                    <option value='Virgin Islands, U.S.'></option>
                                    <option value='Wallis and Futuna'></option>
                                    <option value='Western Sahara'></option>
                                    <option value='Yemen'></option>
                                    <option value='Zambia'></option>
                                    <option value='Zimbabwe'></option>
                                </datalist>
                            ";
                        }
                            
                        if ( $ligne['localisation_mem'] == NULL or ( $ligne['localisation_mem'] == "" )) {
                            echo "
                                <div class='padding'><label class='form-label'>Localisation</label> 
                                <input class='form-input' list='localisation' name='localisation' required></div>
                                <datalist id='localisation' required>
                                    <option value='Cherbourg'></option>
                                    <option value='Saint-Lô'></option>
                                </datalist>
                            ";
                        }
                            
                        if ( $ligne['dateent_mem'] == NULL or ( $ligne['dateent_mem'] == "" )) {
                            echo "
                                <div class='padding'><label class='form-label'>Date d'arrivée</label> 
                                <input class='form-input' type='date' name='dateent' value='2019-06-07' required></div>
                            ";
                        }
                            
                        if ( $ligne['datesrt_mem'] == NULL or ( $ligne['datesrt_mem'] == "" )) {
                            echo "
                                <div class='padding'><label class='form-label'>Date de départ</label> 
                                <input class='form-input' type='date' name='datesrt' value='2019-06-07' required></div>
                            ";
                        }
                        echo "
                                    <div class='flex fullw wrap center'>
                                        <div id='send-update-info-form' class='step-icon-container flex center'><div class='step-icon-circle blue'><i class='fas fa-pen step-icon'></i></div></div>
                                    </div>
                                </div>
                            </div>
                        </div><input type='submit' class='hide'><input type='hidden' name='action' value='update'><input type='hidden' name='id_mem' value='".$_GET['id_mem']."'>
                        </form>
                        ";    
                  
                        }      

                    
                        // ETAPE 1 - FORMULAIRE AGENT
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=1";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        echo "
                        <div class='flex content-container fullw'>
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Formulaire agent</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Envoyer</span> le formulaire agent ou <span class='red-info'>passer</span> cette étape</p>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=send&etape=1'><div id='step-send-form' class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-envelope step-icon'></i></div></div></a>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=1'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div><input type='submit' class='hide'></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                        
                        // ETAPE 1 - FORMULAIRE AGENT UPLOAD
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=2";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        echo "
                        <div class='flex content-container fullw'>
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Formulaire agent</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <form id='uploadbis-form'>
                                        <p class='center font-normal fullw'><span class='green-info'>Confirmer</span> la récéption du formulaire agent ou <span class='red-info'>passer</span> cette étape</p>

                                        <div class='padding fullw spc-top'><label class='form-label'>Formulaire agent :</label> 
                                        <input class='form-input upload-file' id='upload-file' type='file' required></div>

                                        <div class='flex wrap center'>
                                            <div class='step-icon-container flex center locked send-uploadbis-form'><div class='step-icon-circle green'><i class='fas fa-upload step-icon'></i></div></div>

                                            <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=2'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                        
                        // ETAPE 2 - CONVENTION/CONTRAT UPLOAD
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=".$Etape;
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);

                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        echo "
                        <div class='flex content-container fullw'>
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>".$Titre."</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <form id='uploadbis-form'>
                                        <p class='center font-normal fullw'><span class='green-info'>Confirmer</span> la récéption ". $Pre . $Titre ." ou <span class='red-info'>passer</span> cette étape</p>

                                        <div class='padding fullw spc-top'><label class='form-label'>".$Titre." :</label> 
                                        <input class='form-input upload-file' id='upload-file' type='file' required></div>

                                        <div class='flex wrap center'>
                                            <div class='step-icon-container flex center locked send-uploadbis-form'><div class='step-icon-circle green'><i class='fas fa-upload step-icon'></i></div></div>

                                            <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=3,4,5'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ";       
                        } else {
                        
                        // ETAPE 3 - PERSOPASS
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=6";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Persopass</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Envoyer</span> la demande de persopass ou <span class='red-info'>passer</span> cette étape</p>

                                    <div class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-envelope step-icon'></i></div></div>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=6'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                            
                        // ETAPE 3 - PERSOPASS CONFIRMATION
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=7";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Persopass</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Confirmer</span> la réception du persopass ou <span class='red-info'>passer</span> cette étape</p>

                                    <div class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-check step-icon'></i></div></div>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=7'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                            
                        // ETAPE 4 - LEOCARTE
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=8";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Léocarte</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Envoyer</span> la demande de léocarte ou <span class='red-info'>passer</span> cette étape</p>

                                    <div class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-envelope step-icon'></i></div></div>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=8'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                            
                        // ETAPE 4 - LEOCARTE CONFIRMATION
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=9";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Léocarte</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Confirmer</span> la réception de la léocarte ou <span class='red-info'>passer</span> cette étape</p>

                                    <div class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-check step-icon'></i></div></div>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=9'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                            
                        // ETAPE 4 - LEOCARTE CONFIRMATION SICM
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=10";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Léocarte</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'><span class='green-info'>Envoyer</span> la demande d'activation au SICM de la léocarte ou <span class='red-info'>passer</span> cette étape</p>

                                    <div class='step-icon-container flex center'><div class='step-icon-circle green'><i class='fas fa-envelope step-icon'></i></div></div>

                                    <a href='consultation.php?id_mem=".$_GET['id_mem']."&action=skip&etape=10'><div class='step-icon-container flex center'><div class='step-icon-circle red'><i class='fas fa-sign-in-alt step-icon'></i></div></div></a>
                                </div>
                            </div>
                        </div>
                        ";
                        } else {
                            
                        // ETAPE 5 - DEPART
                        $LaSituation = "SELECT * FROM situation WHERE mem_sit=".$_GET['id_mem']." AND etp_sit=11";
                        $ResultatSituation = mysqli_query ( $DataBase, $LaSituation )  or  die(mysqli_error($DataBase) ) ;
                        $ligne = mysqli_fetch_array($ResultatSituation);
                    
                        if ( $ligne['datefin_sit'] == NULL or ( $ligne['datefin_sit'] == "" )) {
                        if ($Complete == 0) {
                            echo "<div class='flex content-container fullw'>";
                        } else {
                            echo "<div class='flex content-container locked fullw'>";
                        }
                            echo "
                            <div class='flex wrap step-container padding'>
                                <div class='step-title-container'><div class='step-title padding'>Départ</div></div><div class='after-triangle'></div>
                                <div class='inbox-content padding flex wrap center'>
                                    <p class='center font-normal fullw'>Le <span class='bold'>départ</span> de cette personne est prévu pour le <span class='bold'>26/06/2019</span> soit <span class='bold'>999 jour(s)</span></p>
                                </div>
                            </div>
                        </div>
                        ";
                        }
                        }}}}}}}}              
                             
                            
                    echo "
                            </div>
                        </div>
                    </div>
                    ";
                    mysqli_close ( $DataBase ) ;
                    ?>

                        
        
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