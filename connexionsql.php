   <?php 
          
    // MySQL Database Settings:
    $username = "****"; // Votre nom d'utilisateur
    $password = "****"; // Votre mot de passe
    $database = "****"; // Le nom de la base de donnée
    $hostname = "localhost"; // l'adresse du serveur mysql (le nom de l'hôte)




	// Pilote de connexion à la base et exécution de la requête SQL:
		$pdo = new PDO ("mysql:host=$hostname;dbname=$database;charset=UTF8",$username,$password); 
          
?>