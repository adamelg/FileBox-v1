<?php 
print_r($_REQUEST);  

    $utilisateur = $_REQUEST['mail_expediteur'];
    $reception = $_REQUEST['mail_destinataire'];
    $message = $_REQUEST['message'];

    // insere les donnees du form dans la table uploader
    $sql = "INSERT INTO uploader(filename, chemin_fichier, email_utilisateur, email_reception, message, file_key) VALUES('$fichier', '".$dossier . $fichier."', '$utilisateur', '$reception', '$message', '$key')"; 
    
        echo($sql); 
    

		$query = $pdo->prepare($sql);
		$query->execute(); 
	// Fin de l'exécution
    
         
                


            echo 'Envoyé';

 
?> 