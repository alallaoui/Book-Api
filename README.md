# Book Library CRUD Api



## Introduction
Ce projet contient tout le nécessaire pour démarrer l'application Book Library CRUD Api.  
Il est composé d'un environnement de développement web fournissant un serveur web préconfiguré basé sur:  
- Docker
- Nginx:1.19.0
- PHP 8.1
- Mysql 8.0

## 1. Installation de l'environnement
### 1.1 Prérequis  
Pour installer l'environnement de Développement, les composants suivants sont requis ainsi que les droits admin sur le poste :  
- Docker

### 1.2 Configuration de l'environnement

#### 1.2.1 Variables d'environments
La fichier [docker.env](docker.env) contient la liste des variables d'environnements :
- `PROJECT_NAME` valeur par défaut **book-api**
- `NGINX_PORT` valeur par défaut **9185**
- `LOCAL_USER` valeur par défaut **1000:1000**


## 2. Utilisatation de docker compose
### 2.1 Initiliasation de l'environnement
`docker-compose up -d`

### 2.2 Arreter l'environnement
`docker-compose stop`

### 2.3 Vérification l'environnement
`docker-compose ps`

## 3. Installation de Symfony
### 3.1 Mise en place du socle
Se connecter au conteneur `php`  
`docker exec -it  books-api-php  bash`

### 3.2 Installation des dépendances
Ensuite dans le dossier /usr/src/app executer la commande  
`composer install --prefer-source`

### 3.3 Génération des assets
`php bin/console assets:install`

### 3.4 Création de la base de donnée
`php bin/console d:d:c`

### 3.5 Création des tables
`php bin/console d:m:m`

### 3.6 Ajouter les jeux de données
`php bin/console d:f:l`

### 3.6 Génération des clés
`php bin/console lexik:jwt:generate-keypair`

## 4 Accès
### 4.1 Documentation de l'API
Pour accèder à la documentation de l'API, vous pouvez utiliser l'URL [http://localhost:9185/api/doc](http://localhost:9185/api/doc)

### 4.2 Mysql
- localhost:3306
- Username: root (par défaut)
- Password: root (par défaut)

### 4.3 PhpMyAdmin
- URL: http://localhost:8081
- Username: root (par défaut)
- Password: root (par défaut)
