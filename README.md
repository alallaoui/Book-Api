# Book Library CRUD Api



## Introduction
Ce projet contient tout le nécessaire pour démarrer l'application Book Library CRUD Api.  
Il est composé d'un environnement de développement web fournissant un serveur web préconfiguré basé sur:  
- Docker
- Nginx:1.19.0
- PHP 8.1
- Mongodb 5.0.8

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


### 3.4 Ajouter les jeux de données
` php bin/console doctrine:mongodb:fixtures:load
`

## 4 Accès
### 4.1 Documentation de l'API
Pour accèder à la documentation de l'API, vous pouvez utiliser l'URL [http://localhost:9185/api/doc](http://localhost:9185/api/doc)

### 4.2 MongoDb server
Se connecter au conteneur `MongoDb`

`docker exec -it books-api_mongodb_1 bash`

Se connecter au serveur `MongoDb`
`mongo -u root -p --authenticationDatabase admin`

- localhost:27017
- Username: root (par défaut)
- Password: root (par défaut)

