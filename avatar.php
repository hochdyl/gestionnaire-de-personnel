<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Avatar</title>
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
    <script type="text/javascript" src="assets/js/image-preview.js"></script>
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
                include('assets/includes/connexion.inc.php');
                $Requete = "SELECT * FROM membres WHERE id_mem=".$_GET['id_mem'] ;
                $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                $ligne = mysqli_fetch_array($Resultat);
                
                if (isset($_POST['action'])) {
                    if ($_POST['action']=='upload') {
                        Upload(); 
                    }
                }
                    function formatSizeUnits($bytes) {
                        if ($bytes >= 1073741824)
                        {
                            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                        }
                        elseif ($bytes >= 1048576)
                        {
                            $bytes = number_format($bytes / 1048576, 2) . ' MB';
                        }
                        elseif ($bytes >= 1024)
                        {
                            $bytes = number_format($bytes / 1024, 2) . ' KB';
                        }
                        elseif ($bytes > 1)
                        {
                            $bytes = $bytes . ' bytes';
                        }
                        elseif ($bytes == 1)
                        {
                            $bytes = $bytes . ' byte';
                        }
                        else
                        {
                            $bytes = '0 bytes';
                        }

                        return $bytes;
                }
                
                function Upload() {
                    $file_name = 'avatar.jpg';
                    
                    $file_tmp_name = $_FILES['fichier_upl']['tmp_name'];
                    $file_size     = $_FILES['fichier_upl']['size'];
                    
                    $Poid = formatSizeUnits($file_size);
                    $t = time();
                    $Date=(date("Y-m-d",$t));
                    
                    $file_dest = 'ressources/'.$_GET['id_mem'].'/'.$file_name;
                    
                    move_uploaded_file($file_tmp_name,$file_dest);
                    
                    include('assets/includes/connexion.inc.php');
                    $Requete = "UPDATE upload SET 
                    mem_upl=".$_GET['id_mem'].",
                    rsc_upl=1,
                    nom_upl='avatar', 
                    date_upl='".$Date."', 
                    poid_upl='".$Poid."'
                    WHERE mem_upl=".$_GET['id_mem']." AND rsc_upl=1" ;
                    $Resultat = mysqli_query ( $DataBase, $Requete )  or  die(mysqli_error($DataBase) ) ;
                    $ligne = mysqli_fetch_array($Resultat);
                    
                    header('Location:avatar.php?id_mem='.$_GET['id_mem']);
                }
                
                echo "
                <div class='maincol-title-container fullw'><div class='maincol-title'>Modifier</div></div>
                <div class='padding fullw flex lcenter'>
                    <div class='lcenter'>
                        <a href='consultation.php?id_mem=".$_GET['id_mem']."'><div class='step-icon-circle gray'><i class='fas fa-arrow-left step-icon center'></i></div></a>
                    </div>
                    <div class='head-container flex wrap'>
                        <div class='font-rbig bold fullw'>".$ligne['nom_mem']."</div>
                        <div class='font-big italic'>".$ligne['prenom_mem']."</div>
                    </div>
                </div>
        
                <div class='content-container padding center fullw'>
            
                    <form id='form' method='post' enctype='multipart/form-data'>
                    <div class='avatar-upload'>
                        <div class='avatar-edit'>
                            <input type='file' id='upload-file' name='fichier_upl' />
                            <label for='upload-file'><i class='fas fa-user-circle'></i></label>
                        </div>
                        <div class='avatar-preview'>
                            <div id='imagePreview' style='background-image: url(ressources/".$_GET['id_mem']."/avatar.jpg);'>
                            </div>
                        </div>
                        <div id='send-form' class='step-icon-container flex center locked send-upload-form'><div class='step-icon-circle green'><i class='fas fa-upload step-icon'></i></div></div>
                    </div>
                    <input type='hidden' name='id_mem' value=".$_GET['id_mem'].">
                    <input type='submit' class='hide'>
                    <input type='hidden' name='action' value='upload'>
                    </form>
                </div>";
                ?>
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