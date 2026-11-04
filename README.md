# Gestion Scolaire – IHEM/SO 🎓

Site web et système de gestion scolaire en **PHP / MySQL** pour l'**IHEM/SO** (Institut des Hautes Études de Management), qui propose des formations BTS, Licence et Master.

## ✨ Fonctionnalités

### Site public
- Page d'accueil : présentation de l'institut, filières (BTS, Licence, Master), actualités et événements, carte « Nous trouver »
- **Pré-inscription en ligne** avec choix de la filière
- **Candidature à la bourse** IHEM/SO
- **Formulaire de contact** (messages enregistrés en base de données)

### Espaces utilisateurs
- Connexion sécurisée (mots de passe chiffrés avec bcrypt)
- Espaces séparés selon le rôle : fondateur / administrateur, professeur, étudiant

### Extension en cours : évaluation en ligne et analyse prédictive
Le fichier [README_INSTALLATION.md](README_INSTALLATION.md) décrit un module complémentaire :
- **Examens en ligne anti-triche** : blocage du copier-coller, détection des changements d'onglet et de la sortie du plein écran, chronomètre, remise automatique de la copie
- **Correction automatique** des QCM
- **Analyse prédictive** : alerte en cas de risque de décrochage, prévision du taux de réussite par filière, professeurs à accompagner

## 🛠️ Technologies

- PHP (PDO), MySQL
- HTML, CSS, JavaScript

## 📁 Structure

```
gestion-d-ecole-/
├── index.php                # Page d'accueil de l'institut
├── connexion.php / logout.php
├── preinscription.php       # Formulaire de pré-inscription (+ version .html)
├── bourses.php              # Candidature à la bourse
├── contact_enregistrer.php  # Formulaire de contact
├── pass.php                 # Utilitaire : génère un mot de passe chiffré (bcrypt)
├── style.css
└── README_INSTALLATION.md   # Guide d'installation du module d'évaluation
```

## 🚀 Installation (XAMPP)

1. Clonez le dépôt dans `C:\xampp\htdocs\` :
   ```bash
   git clone https://github.com/abdoulcoulibaly-web/gestion-d-ecole-.git
   ```
2. Démarrez Apache et MySQL, puis créez la base `base_ecole` dans phpMyAdmin.
3. Réglez la connexion à la base dans `config/database.php`.
4. Ouvrez [http://localhost/gestion-d-ecole-](http://localhost/gestion-d-ecole-).

Les détails de l'installation sont dans [README_INSTALLATION.md](README_INSTALLATION.md).

## 👤 Auteur

**Coulibaly Abdoul-Ganime** – [GitHub](https://github.com/abdoulcoulibaly-web)
