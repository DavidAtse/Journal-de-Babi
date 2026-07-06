<?php
// Copiez ce fichier en "mail_config.php" (à côté de celui-ci) et remplissez vos identifiants.
// mail_config.php est ignoré par git (voir .gitignore) : ne partagez jamais ce fichier rempli.

// Compte Gmail utilisé pour ENVOYER les emails du formulaire de contact
define('SMTP_USERNAME', 'votre-adresse@gmail.com');

// Mot de passe d'application Gmail (16 caractères, PAS votre mot de passe Gmail normal)
// À générer sur : https://myaccount.google.com/apppasswords
define('SMTP_PASSWORD', 'xxxx xxxx xxxx xxxx');

// Adresse qui doit RECEVOIR les messages du formulaire de contact
define('CONTACT_RECEIVER', 'daatsey24@gmail.com');
