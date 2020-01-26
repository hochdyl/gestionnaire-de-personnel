<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Modifier</title>
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
                <?php 
                $t = time();
                $Date=(date("Y-m-d",$t));
                
                
                if ( isset ($_GET['action'])) {
                    if ($_GET['action'] == 'update') { Update(); }
                }
                
                function Update() {
                    include('assets/includes/connexion.inc.php');
                    $RequeteBefore = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'];
                    $ResultatRequeteBefore = mysqli_query ( $DataBase, $RequeteBefore )  or  die(mysqli_error($DataBase) ) ;
                    $ligne = mysqli_fetch_array($ResultatRequeteBefore);
                    
                    $Before = $ligne['statut_mem'];
                    $After  = $_GET['statut'];
                    
                    
                    $Requete = "UPDATE membres SET 
                    nom_mem='".$_GET['nom']."',
                    prenom_mem='".$_GET['prenom']."',
                    mail_mem='".$_GET['mail']."',
                    datenaiss_mem='".$_GET['datenaiss']."',
                    pays_mem='".$_GET['pays']."',
                    statut_mem='".$_GET['statut']."',
                    localisation_mem='".$_GET['localisation']."',
                    dateent_mem='".$_GET['dateent']."',
                    datesrt_mem='".$_GET['datesrt']."'
                    WHERE id_mem=".$_GET['id_mem'] ;

                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                
                    
                    
                    if ($Before != $After) {
                        $Requete = "DELETE FROM situation WHERE mem_sit=".$_GET['id_mem'] ;
                        $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;


                        if ( $_GET['statut'] == 'Stagiaire') {
                            $Etp = "SELECT * FROM etapes WHERE numero_etp NOT IN (SELECT numero_etp FROM etapes WHERE numero_etp IN ('2.2','2.3'))" ;
                            $ResultatEtp = mysqli_query ( $DataBase, $Etp )  or  die(mysqli_error($DataBase) ) ;


                            $Mem = "SELECT id_mem FROM membres WHERE id_mem=".$_GET['id_mem'] ;
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


                            $Mem = "SELECT id_mem FROM membres WHERE id_mem=".$_GET['id_mem'] ;
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


                            $Mem = "SELECT id_mem FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                            $ResultatMem = mysqli_query ( $DataBase, $Mem )  or  die(mysqli_error($DataBase) ) ;
                            $LeMem = mysqli_fetch_array($ResultatMem);


                            while (  $ligne = mysqli_fetch_array($ResultatEtp)  ) {
                                $AjouterEtp = "INSERT INTO situation ( mem_sit , etp_sit , datedeb_sit , datefin_sit )
                                VALUES ( ".$LeMem['id_mem']." , ".$ligne['id_etp']." , NULL , NULL )" ;
                                $Resultat = mysqli_query ( $DataBase, $AjouterEtp )  or  die(mysqli_error($DataBase) ) ;
                            }   
                        }
                    }
                    include('assets/includes/popup-info.inc.php');
                    mysqli_close ( $DataBase ) ;
                }
           
                
                
                
                
                include('assets/includes/connexion.inc.php');
                $Requete = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                $ligne = mysqli_fetch_array($Resultat);
                
                
                echo "
                <div class='maincol-title-container fullw'><div class='maincol-title'>Modifier</div></div>
                <div class='padding floatl'>
                    <div class='lcenter'>
                        <a href='consultation.php?id_mem=".$_GET['id_mem']."'><div class='step-icon-circle gray overall'><i class='fas fa-arrow-left step-icon center'></i></div></a>
                    </div>
                </div>
                
                <form id='form'>
                <div class='content-container flex wrap lcenter fullw top-page'>
                    <div class='padding fullw center'><label class='form-label'>Nom</label> 
                    <input class='form-input' type='text' name='nom' value='".$ligne['nom_mem']."' required autofocus></div>
                        
                    <div class='padding fullw center'><label class='form-label'>Prénom</label> 
                    <input class='form-input' type='text' name='prenom' value='".$ligne['prenom_mem']."' required></div>
                        
                    <div class='padding fullw center'><label class='form-label'>Email</label> 
                    <input class='form-input' type='email' name='mail' value='".$ligne['mail_mem']."' required></div>
                    
                    <div class='padding fullw center'><label class='form-label'>Date de naissance</label> 
                    <input class='form-input' type='date' name='datenaiss' value='".$ligne['datenaiss_mem']."' max='".$Date."' required></div>

                    <div class='padding'><label class='form-label'>Pays de naissance</label>
                    <input class='form-input' list='pays' name='pays' value='".$ligne['pays_mem']."' required></div>
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

                    <div class='padding fullw center'><label class='form-label'>Statut</label> 
                    <input class='form-input' list='statut' name='statut' value='".$ligne['statut_mem']."' required></div>
                                <datalist id='statut' required>
                                    <option value='ATER'></option>
                                    <option value='Doctorant'></option>
                                    <option value='Ingénieur de recherche'></option>
                                    <option value='Post-Doctorant'></option>
                                    <option value='Stagiaire' selected></option>
                                </datalist>

                    <div class='padding fullw center'><label class='form-label'>Localisation</label> 
                    <input class='form-input' list='localisation' name='localisation' value='".$ligne['localisation_mem']."' required></div>
                                <datalist id='localisation' required>
                                    <option value='Cherbourg'></option>
                                    <option value='Saint-Lô'></option>
                                </datalist>
                    
                    <div class='padding fullw center'><label class='form-label'>Date d'arrivée</label> 
                    <input class='form-input' type='date' name='dateent' value='".$ligne['dateent_mem']."' required></div>
                    
                    <div class='padding fullw center'><label class='form-label'>Date de départ</label> 
                    <input class='form-input' type='date' name='datesrt' value='".$ligne['datesrt_mem']."' required></div>
                                
                    <div class='flex fullw wrap center'>
                        <div id='send-form' class='step-icon-container flex center'><div class='step-icon-circle blue'><i class='fas fa-pen step-icon'></i></div></div>
                    </div>
                </div><input type='hidden' name='action' value='update'><input type='submit' class='hide'><input type='hidden' name='id_mem' value='".$_GET['id_mem']."'>
                </form>
            </div>
        </div>" ;
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