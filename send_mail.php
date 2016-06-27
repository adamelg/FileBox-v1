<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="description" content="Exercice sur le WeTransfer"/>
		<meta name="keywords" content="ACS, groupe, exercice, WeTransfer, partage"/>
		<meta name="author" content="Christophe P, Adam E, Adam M"/>
		<title>Exercice - WeTransfer</title>
		
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/> <!-- Bootstrap -->
		<link href="style/style.css" rel="stylesheet" text="text/css"/> <!-- Propre style -->
	</head>
	
	<body>
		
		<section class="container">
		
		<!-- ==== DEBUT MODULE UPLOAD ==== --> 
		
			<?php
/*              mail('julien.g@codeur.online', 'yop', 'yopyop');*/
                $key = (md5($fichier.$mail_expediteur.$mail_destinataire.rand()));

                ini_set('upload_tmp_dir', '/home/adame/www/tmp'); 
                print_r($_FILES);
                print_r($_REQUEST);
            
            
                $dossier = 'upload/';
                $fichier = basename($_FILES['avatar']['name']); 
                $taille_maxi = 10000000000000;
                $taille = filesize($_FILES['avatar']['tmp_name']);
                $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.jp2', '.webp', '.ppt', '.pdf', '.psd', '.mp3', '.xls', '.xlsx', '.swf', '.doc','.docx', '.odt', '.odc', '.odp', '.odg', '.mpp', '.m4a', '.mp4', '.avii'); 
                $extension = strrchr($_FILES['avatar']['name'], '.');
            
                //Début des vérifications de sécurité...
                if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
                }
                if($taille>$taille_maxi)
                {
                     $erreur = 'Le fichier est trop gros...';
                }
                if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
                {
                     //On formate le nom du fichier ici...
                     $fichier = strtr($fichier, 
                          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $key)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...



                     {
                          echo 'Upload effectué avec succès !';
                     }
                     else //Sinon (la fonction renvoie FALSE).
                     {
                          echo 'Echec de l\'upload !';
                     }
                }
                else 
                {
                     echo $erreur;  
                }
            
        // ==== FIN SCRIPT UPLOAD ==== \\
            


        // ==== DEBUT SCRIPT MAIL ==== \\    
                				
				$mail_expediteur = $_REQUEST['mail_expediteur'];
				$mail_destinataire = $_REQUEST['mail_destinataire'];
				$message = $_REQUEST['message'];


/*
                echo $mail_expediteur.'  '.$mail_destinataire.'  '.$message.'  '.$key;
*/

				
				if (isset($_REQUEST['mail_destinataire']) AND isset($_REQUEST['mail_expediteur']) AND isset($_REQUEST['message']))
				{
					echo '<p>Mail envoyé avec succès !</p><br/>';
					
					//=====Envois du mail au destinataire.
					$mail = $mail_destinataire; // Déclaration de l'adresse de destination.
					if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
					{
						$passage_ligne = "\r\n";
					}
					else
					{
						$passage_ligne = "\n";
					}
					//=====Déclaration des messages au format texte et au format HTML.
					$message_txt = 
					$mail_expediteur." vous a envoyé un fichier. \n 
					Vous pouvez dès maintenant télécharger votre fichier à cette adresse : http://adame.student.codeur.online/25_wetransfer/download.php?key=".$key." 
					\n Grâce au WeTransfer made in ACS, tous vos partages sont des plus simples !";
					$message_html =
					"<html>
					<head>
					</head>
					<body>
					<h1> ".$mail_expediteur." vous a envoyé un fichier </h1>
					<p>Vous pouvez dès maintenant <a href=\"http://adame.student.codeur.online/25_wetransfer/download.php?key=".$key."\">télécharger votre fichier</a></p>
					<br/> 
					<p>Grâce au WeTransfer made in ACS, tous vos partages sont des plus simples !<p>
					</body>
					</html>";
					//==========
					
					//=====Création de la boundary
					$boundary = "-----=".md5(rand());
					//==========
					
					//=====Définition du sujet.
					$sujet = "Vous avez reçu un nouveau fichier depuis l'ACS WeTransfer !";
					//=========
					
					//=====Création du header de l'e-mail.
					$header = "From: \"Adam.m\"<adam.m@codeur.online>".$passage_ligne;
					$header.= "Reply-to: \"Adam.m\" <adam.m@codeur.online>".$passage_ligne;
					$header.= "MIME-Version: 1.0".$passage_ligne;
					$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
					//==========
					
					//=====Création du message.
					$message = $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format texte.
					$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_txt.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format HTML
					$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_html.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					//==========
					
					//=====Envoi de l'e-mail.
					mail($mail,$sujet,$message,$header);
					//==========
/*
					echo '<p>Mail 1 envoyé</p>';
*/
					
					//==========Envois du mail a l'expéditeur (confirmation de l'envois)
					
					
					
					$mail = $mail_expediteur; // Déclaration de l'adresse de destination.
					if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
					{
						$passage_ligne = "\r\n";
					}
					else
					{
						$passage_ligne = "\n";
					}
					//=====Déclaration des messages au format texte et au format HTML.
					$message_txt = 
					"L'envoi de votre fichier a été fait avec succès.\n 
					Vous pouvez dès maintenant télécharger votre fichier à cette adresse : http://adame.student.codeur.online/25_wetransfer/download.php?key=".$key.". 
					\n Grâce au WeTransfer made in ACS, tous vos partages sont des plus simples !";
					$message_html =
					"<html>
					<head>
					</head>
					<body>
					<h1>L'envoi de votre fichier a été fait avec succès</h1>
					<p>Vous pouvez dès maintenant <a href=\"http://adame.student.codeur.online/25_wetransfer/download.php?key=".$key."\">télécharger votre fichier</a></p> 
					<br/>
					<p>Grâce au WeTransfer made in ACS, tous vos partages sont des plus simples !<p>
					</body>
					</html>";
					//==========
					
					//=====Création de la boundary
					$boundary = "-----=".md5(rand());
					//==========
					
					//=====Définition du sujet.
					$sujet = "Merci d'avoir utilisé notre WeTransfer !";
					//=========
					
					//=====Création du header de l'e-mail.
					$header = "From: \"Adam.m\"<adam.m@codeur.online>".$passage_ligne;
					$header.= "Reply-to: \"Adam.m\" <adam.m@codeur.online>".$passage_ligne;
					$header.= "MIME-Version: 1.0".$passage_ligne;
					$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
					//==========
					
					//=====Création du message.
					$message = $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format texte.
					$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_txt.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary.$passage_ligne;
					//=====Ajout du message au format HTML
					$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
					$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
					$message.= $passage_ligne.$message_html.$passage_ligne;
					//==========
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
					//==========
					
					//=====Envoi de l'e-mail.
					mail($mail,$sujet,$message,$header);
					//==========
/*
					echo '<p>Mail 2 envoyé</p>';
*/
				}
            
            
        // ==== FIN SCRIPT MAIL ==== \\   
            
            
            
            
                // ==== INCLUDE PILOTE CONNEXION SQL ET REQUETE ==== \\
                include('connexionsql.php');
                include('add_fichier.php');             
				
			?>
		</section>
		<!-- Début des scripts -->		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- Fin des scripts -->
	</body>
</html>		 					