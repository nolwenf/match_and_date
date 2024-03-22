
# Projet Web - Site de rencontre

Projet réalisé par Ange Gonzalez et Nolwen Favier dans le cadre du cours de Web à l'Université Cote d'Azur.

## Présentation du projet
C'est un site de rencontre qui n'utilise pas de babse de données. Il est réalisé en PHP, HTML, CSS et JS. Le logo et tout le design a été réalisé par nos soins.
Nous avons constitué une API et un système de matching et de messagerie instantannée en utilisant WebSocket et des fichiers JSON car nous ne pouvions pas utiliser de base de données.

## Librairies nécessaires PHP
- Ratchet (WebSocket)

Aucune autre installation ne devrait être nécessaire. et tous les fichiers de composer sont déjà dans l'arborescence.

## Utilisation 

Possibilités de créer un compte, se connecter, rechercher un match, envoyer des messages, modifier son profil et se déconnecter. De nombreuses fonctionnalités visuelles et animations sont disponibles.

## Lancement du site

php -S localhost:port
php websocket.php (dans un autre terminal pour le serveur websocket)

## Arborescence

```
.
├── image/*
├── style
│   ├── css
│   │   ├── bouton.css
│   │   ├── chat.css
│   │   ├── login.css
│   │   ├── match.css
│   │   ├── register.css
│   │   ├── index.css
├── api
│   ├── addMatch.php
│   ├── checkMatch.php
│   ├── getChat.php
│   ├── getNextMatch.php  
chat.php
index.php
login.php
match.php
register.php
websocket.php
logout.php
```
Ceci est un proof of concept il n'y a pas de persistence (pas de base de données interdite dans le sujet). Mais les matchs et les likes sont gardés en mémoire.


