# Extension — Évaluation en ligne + Anti-triche + Analytique prédictive

Module à greffer sur ton projet de gestion d'école, **aligné sur la base `base_ecole`**
(multi-école `id_ecole`, `utilisateurs.id_role`, mots de passe bcrypt).

## 1. Pourquoi cette couche d'adaptation ?

Ton ancien code suppose un schéma différent de la base que tu m'as envoyée :

| Ancien code | Base `base_ecole` |
|---|---|
| `utilisateurs.role` (texte) | `utilisateurs.id_role` (entier → `roles`) |
| `utilisateurs.id_filiere` | tables `etudiants` / `professeurs` séparées |
| mono-école | `id_ecole` partout |
| mot de passe en clair | bcrypt (`$2y$10$…`) |
| base `gestion_ecole` | base `base_ecole` |

→ avec `base_ecole`, **l'ancien `connexion.php` ne peut pas fonctionner**.
Les fichiers `config/database.php` + `includes/auth.php` corrigent ça une fois pour toutes.

## 2. Installation

1. Copie le dossier `gestion_ecole/` dans `htdocs/` (XAMPP).
2. Vérifie `config/database.php` (nom de base = `base_ecole`, user/pass).
3. Dans phpMyAdmin, importe d'abord **ton dump existant**, puis :
   `sql/extension_evaluation_ia.sql` (crée les 6 nouvelles tables + 1 vue).
4. Donne les droits d'écriture à `uploads/devoirs/`.
5. Connecte-toi via `connexion.php`. Comptes de test du dump :
   - `fondateur@test.com`, `prof@test.com`, `etudiant@test.com` (même mot de passe que dans ta base).

> ⚠️ Les comptes `etudiant@test.com` / `prof@test.com` doivent aussi exister dans les
> tables `etudiants` / `professeurs`. Ton dump ne contient que `utilisateurs` ; ajoute
> les lignes correspondantes (voir `sql/donnees_demo.sql` si tu veux des données de test).

## 3. Ce que ça ajoute

### Espace professeur
- `prof/creer_examen.php` — générateur de devoir **dynamique** : QCM (auto-corrigés),
  réponses libres, dépôt de fichier, lien visio, durée, mode anti-triche.
- `prof/liste_examens.php` — publier/clôturer, voir les copies **triées par score de suspicion**.

### Espace étudiant (composition sécurisée)
- `etudiant/passer_examen.php` — interface d'examen avec :
  - blocage **copier / coller / couper** sur les zones de réponse ;
  - détection **changement d'onglet/fenêtre** (`visibilitychange`, `blur`) ;
  - détection sortie **plein écran** + raccourcis outils dev ;
  - **chronomètre**, remise automatique après 3 alertes ou temps écoulé ;
  - journalisation temps réel via `api/log_triche.php` (`navigator.sendBeacon`).
- `etudiant/soumettre_examen.php` — auto-correction des QCM + upload + crochet détection IA.

### Espace admin — `admin/analytics_ia.php`
- **Alerte décrochage** : score de risque par étudiant (moyenne + tendance 30 j + assiduité),
  chaque alerte est explicable.
- **Prévision du taux de réussite** par filière (% moyenne ≥ 10).
- **Professeurs à accompagner** : analyse croisée (moyenne de cours basse, retard de saisie, etc.).

## 4. Détection de texte par IA (optionnel)

`soumettre_examen.php` contient `analyser_ia_texte()` avec :
- une **heuristique locale** active par défaut (uniformité des phrases) ;
- un bloc commenté prêt pour une **vraie API** (Sapling, GPTZero, Originality) via clé
  d'environnement `AI_DETECTOR_KEY`.

Pour analyser les PDF/DOCX déposés, ajoute `smalot/pdfparser` et `phpoffice/phpword`
puis appelle `analyser_ia_texte()` sur le texte extrait.

## 5. Pour aller vers un vrai modèle ML

La fonction `score_risque()` sert de **jeu de features** : exporte les agrégats
(moyenne, delta de tendance, présence) vers un micro-service Python (FastAPI +
scikit-learn, régression logistique sur l'historique des abandons réels). Le scoring
par règles reste le fallback explicable.

---

## 6. Migration complète du dossier d'origine (mise à jour)

Tout le projet initial a été migré vers le schéma `base_ecole` et réorganisé :

**Racine (public + connexion)**
- `index.php` — page d'accueil (design conservé, requêtes corrigées + `id_ecole`)
- `connexion.php`, `logout.php` — auth bcrypt + `id_role`
- `preinscription.php` — formulaire public → table `pre-inscription` (avec `prenom_pre`)
- `bourses.php` — candidature bourse **pour étudiant connecté** → table `bourse` (`id_user`, `moyenne`, `lettre`, `statut`)
- `contact_enregistrer.php` — formulaire de contact public → table `contact`

**`admin/`** (réservé admin/fondateur, garde `require_role`)
- `admin_dashboard.php`, `analytics_ia.php`
- `ajouter_etudiant.php` / `ajouter_prof.php` — créent `utilisateurs` **+** `etudiants`/`professeurs` en transaction
- `liste_etudiants.php`, `gestion_matieres.php`, `gestion_emploi.php`
- `gestion_paiements.php` — met à jour `etudiants.montant_paye`
- `gestion_periodes.php`, `envoyer_notification.php`, `actualites.php`
- `candidature_dash.php` — approuver/refuser les bourses
- `pre-inscription_dash.php` — corrige les bugs d'origine (`execution()`, backticks)
- `contact.php` — liste des messages reçus
- `generer_bulletin.php` — bulletin avec moyenne pondérée + rang

**`prof/`** — `prof_dashboard.php` (saisie notes corrigée), `creer_examen.php`, `liste_examens.php`
**`etudiant/`** — `etudiant_dashboard.php`, `mes_examens.php`, `passer_examen.php`, `soumettre_examen.php`, `archives_etudiant.php`

### Fichiers d'origine remplacés / supprimés
- `db_config.php` → remplacé par `config/database.php` (sans HTML, sinon les redirections cassent).
- `traitement_bourse.php` et `traitement_preinscription.php` → **supprimés** : ils appelaient un `db_connect.php` inexistant, la variable `$conn` non définie, et des colonnes/tables absentes de `base_ecole`. Leur rôle est repris par `bourses.php` et `preinscription.php`.
- `contact.php` d'origine (sidebar vide) → remplacé par `admin/contact.php` (liste des messages).

### Points de sécurité corrigés au passage
- `liste_etudiants.php` n'avait **aucun contrôle de rôle** et supprimait via un simple lien GET → garde admin + confirmation ajoutées.
- Mots de passe : toute création passe maintenant par `password_hash()` ; la connexion par `password_verify()`.
