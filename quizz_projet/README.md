Quizz-Projet

Description

Quizz-Projet est une application web qui permet aux utilisateurs de créer, gérer et jouer à des quizz. Ce projet est réalisé en utilisant une architecture MVC et offre une interface utilisateur conviviale pour interagir avec les quizz. L’application inclut des fonctionnalités telles que la gestion des utilisateurs, des quizz et des résultats de manière dynamique.

Technologies utilisées
	•	Back-end : PHP avec une architecture MVC
	•	Base de données : MySQL
	•	Front-end : HTML, CSS, JavaScript (modulaire)
	•	Framework CSS : Bootstrap pour un design réactif
	•	Gestion des dépendances : Composer
	•	Authentification : PHP avec sessions
	•	API externe (si applicable) : Si tu utilises une API externe pour la gestion des quizz ou d’autres fonctionnalités.

Instructions d’installation

Installer le projet via Git

Clonez le projet à l’aide de Git en exécutant la commande suivante dans votre terminal :

git clone https://github.com/Nathan876/quizz_projet.git

Préparer la base de données
	1.	Créez une base de données MySQL pour le projet (par exemple quizz_projet).
	2.	Importez la base de données en utilisant le fichier dump fourni (db_dump.sql ou un autre fichier équivalent).
	3.	Modifiez les informations de connexion à la base de données dans le fichier de configuration PHP (config.php ou un autre fichier de configuration) pour correspondre à votre configuration locale.

Installer les dépendances

Exécutez la commande suivante pour installer les dépendances via Composer :

composer install

Configurer l’environnement
	1.	Copiez le fichier .env.example et renommez-le en .env.
	2.	Modifiez les variables dans le fichier .env pour qu’elles correspondent à votre configuration locale, notamment les informations de la base de données.
	3.	Si vous avez besoin d’une clé API (par exemple pour des services externes), ajoutez-la dans le fichier .env sous la variable correspondante.

Lancer l’application
	1.	Assurez-vous que votre serveur local (comme MAMP ou XAMPP) est bien démarré et que le répertoire contenant le projet est accessible via le serveur local.
	2.	Ouvrez votre navigateur et accédez à l’application via l’URL suivante :

http://localhost/quizz_projet/

Exécution des fixtures (si applicable)

Si vous avez besoin de lancer des fixtures (données initiales), exécutez le script suivant dans le répertoire principal du projet :

php scripts/fixture.php

Fonctionnalités principales
	•	Création de Quizz : Ajoutez de nouveaux quizz avec des questions et des réponses.
	•	Gestion des utilisateurs : Inscription, connexion et gestion des utilisateurs.
	•	Participation aux quizz : Les utilisateurs peuvent participer et répondre aux quizz.
	•	Affichage des résultats : Après avoir répondu aux questions, les résultats sont affichés.
	•	Interface réactive : Interface utilisateur responsive grâce à Bootstrap, permettant une utilisation sur des appareils de différentes tailles.

Contributeurs
	•	Nathan876 : Développeur principal, création et gestion des quizz.

Après avoir installé le projet, vous pouvez vous connecter à l’application avec les informations suivantes :
	•	Adresse e-mail : a@a.com
	•	Mot de passe : test
