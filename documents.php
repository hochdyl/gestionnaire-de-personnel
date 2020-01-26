<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Documents</title>
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
                
                <div class='popup-info-visibility uploaddoc a-fadeout'>
                    <div class='popup-info-overlay'></div>
                    <div class='popup-info padding center'>
                        <label><input class='popup-info-close' type=button value='X'/></label>
                        <form id='upload-form'>
                            <span class='bold font-normal'>Ajouter un document</span>

                            <div class='padding'><label class='form-label'>Type de document</label> 
                                <input class='form-input' list='statut' name='doctype' required></div>
                                <datalist id='statut' required>
                                    <option value="Convention de stage"></option>
                                    <option value="Convention doctorale"></option>
                                    <option value="Contrat de travail"></option>
                                    <option value="RIB"></option>
                                    <option value="Formulaire agent" selected></option>
                                </datalist>
                            
                            <div class='padding fullw spc-top'><label class='form-label'>Ajouter le document :</label> 
                            <input class='form-input upload-file' id='upload-file' type='file' required></div>

                            <div class='step-icon-circle green spc-left locked send-upload-form'><i class="fas fa-upload step-icon center"></i></div><input type='submit' class='hide'>
                        </form>
                    </div>
                </div>
                
                <div class='popup-info-visibility delete a-fadeout'>
                    <div class='popup-info-overlay'></div>
                    <div class='popup-info padding center'>
                        <label><input class='popup-info-close' type=button value='X'/></label>
                        <form>
                            <span class='font-normal'>Êtes-vous sûr de vouloir supprimer :<br></span>
                            <span class='bold font-normal'>(NOM DU DOC)</span>

                            <div class='step-icon-container flex center'><div class='step-icon-circle red'><i class="fas fa-trash step-icon"></i></div></div>
                        </form>
                    </div>
                </div>
                
                <div class='popup-info-visibility notification'>
                    <div class='popup-notification padding center font-normal'>
                        <i class="fas fa-exclamation-circle"></i> ACTION REUSSI <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                
                
                <div class='maincol-title-container fullw'><div class='maincol-title'>Documents</div></div>
                <div class='padding fullw flex lcenter'>
                    <div class='lcenter'>
                        <a href='consultation.php'><div class='step-icon-circle gray'><i class="fas fa-arrow-left step-icon center"></i></div></a>
                        <div class='step-icon-circle green spc-left popup-info-uploaddoc-trigger'><i class="fas fa-upload step-icon center"></i></div>
                    </div>
                    <div class='head-container flex wrap'>
                        <div class='font-rbig bold fullw'>HAJABDOLLAHI</div>
                        <div class='font-big italic'>Zarha</div>
                    </div>
                </div>
                
                <div class='content-container padding flex wrap lcenter fullw'>
                    <div class='doc-container center spc-top'>
                        <div class='doc-title'>CONVENTION DE STAGE</div>
                        <div class='doc-select flex fullw'>
                            <div class='doc-select-download w1-2 padding'><i class="fas fa-download"></i></div>
                            <div class='doc-select-delete w1-2 padding popup-info-delete-trigger'><i class="fas fa-trash"></i></div>
                        </div>
                    </div>
                    
                    <div class='doc-container center spc-top'>
                        <div class='doc-title'>RIB</div>
                        <div class='doc-select flex fullw'>
                            <div class='doc-select-download w1-2 padding'><i class="fas fa-download"></i></div>
                            <div class='doc-select-delete w1-2 padding popup-info-delete-trigger'><i class="fas fa-trash"></i></div>
                        </div>
                    </div>
                    
                    <div class='doc-container center spc-top'>
                        <div class='doc-title'>LETTRE</div>
                        <div class='doc-select flex fullw'>
                            <div class='doc-select-download w1-2 padding'><i class="fas fa-download"></i></div>
                            <div class='doc-select-delete w1-2 padding popup-info-delete-trigger'><i class="fas fa-trash"></i></div>
                        </div>
                    </div>
                    
                    <div class='doc-container center spc-top'>
                        <div class='doc-title'>FORMULAIRE AGENT</div>
                        <div class='doc-select flex fullw'>
                            <div class='doc-select-download w1-2 padding'><i class="fas fa-download"></i></div>
                            <div class='doc-select-delete w1-2 padding popup-info-delete-trigger'><i class="fas fa-trash"></i></div>
                        </div>
                    </div>
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