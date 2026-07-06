# MANUEL UTILISATEUR
## Gestion Académique - SupTech Business School

---

## 📋 Table des matières

1. [Introduction](#introduction)
2. [Authentification](#authentification)
3. [Interface principale](#interface-principale)
4. [Tableau de bord](#tableau-de-bord)
5. [Gestion des étudiants](#gestion-des-étudiants)
6. [Gestion des classes](#gestion-des-classes)
7. [Gestion des notes](#gestion-des-notes)
8. [Gestion des paiements](#gestion-des-paiements)
9. [Emploi du temps](#emploi-du-temps)
10. [Statistiques](#statistiques)
11. [Foire aux questions](#foire-aux-questions)

---

## 👋 Introduction

Bienvenue dans l'application de Gestion Académique de SupTech Business School. Ce guide vous aidera à utiliser efficacement tous les modules de l'application.

### Types d'utilisateurs

- **Administrateur** : Accès complet à tous les modules
- **Responsable Scolarité** : Gestion des étudiants, classes, inscriptions, paiements
- **Enseignant** : Saisie des notes et consultation des étudiants

---

## 🔐 Authentification

### Connexion

1. Ouvrir votre navigateur et aller à `http://localhost/gestion_academique`
2. Saisir votre **email** et **mot de passe**
3. Cliquer sur **"Se connecter"**

### Première connexion

Si c'est votre première connexion :
1. Vous recevez des identifiants temporaires de votre administrateur
2. Changez votre mot de passe dans votre profil
3. Vous êtes maintenant connecté(e)

### Déconnexion

1. Cliquer sur votre **nom** en haut à droite
2. Cliquer sur **"Déconnexion"**

### Oubli de mot de passe

Contactez votre administrateur pour réinitialiser votre mot de passe.

---

## 🏠 Interface principale

### Éléments de l'interface

#### Barre de navigation (en haut)
- Logo et nom de l'école
- Lien vers le tableau de bord
- Menu utilisateur avec déconnexion

#### Barre latérale (à gauche)
- Menu de navigation selon votre rôle
- Accès rapide aux modules disponibles
- Lien de déconnexion

#### Zone principale (au centre)
- Contenu du module sélectionné
- Formulaires et tableaux
- Données et actions

### Raccourcis clavier

- **Ctrl+K** : Ouvrir la recherche (si activée)
- **Échap** : Fermer les modales

---

## 📊 Tableau de bord

### Accès
Menu → **Tableau de Bord** ou cliquer sur le logo

### Éléments affichés

#### 1. Statistiques en cartes (première ligne)
- **Étudiants Actifs** : Nombre d'étudiants actuellement inscrits
- **Enseignants** : Nombre d'enseignants
- **Classes** : Nombre de classes disponibles

#### 2. Statistiques en cartes (deuxième ligne)
- **Modules** : Nombre de modules de cours
- **Inscriptions Actives** : Inscriptions en cours
- **Paiements Traités** : Montant des paiements effectués

#### 3. Listes récentes
- **Derniers étudiants inscrits** : Les 5 derniers enregistrements
- **Dernières notes enregistrées** : Les 5 dernières notes saisies

### Interprétation des données

Les statistiques se mettent à jour **automatiquement** lors de :
- L'ajout d'un nouvel étudiant
- L'inscription d'un étudiant
- L'enregistrement de notes
- Un paiement effectué

---

## 👨‍🎓 Gestion des étudiants

### Accès
Menu → **Étudiants** → **Ajouter un étudiant** ou **Liste**

### Ajouter un étudiant

1. Cliquer sur **"+ Ajouter un étudiant"**
2. Remplir le formulaire :
   - Nom et Prénom (obligatoires)
   - Date de naissance (obligatoire)
   - Sexe (obligatoire)
   - Email (optionnel mais recommandé)
   - Téléphone (optionnel)
   - Adresse (optionnelle)
   - **Classe (obligatoire)**
3. Cliquer sur **"Enregistrer"**
4. Un **matricule** est généré automatiquement
5. Une notification de confirmation s'affiche

### Consulter la liste des étudiants

1. Aller à **Étudiants** → **Liste**
2. La liste affiche :
   - Matricule
   - Nom et Prénom
   - Email
   - Classe
   - Téléphone
   - Date d'inscription

### Rechercher un étudiant

1. Utiliser le formulaire de **recherche** en haut :
   - Saisir : matricule, nom, email
   - Sélectionner une classe (optionnel)
   - Cliquer sur **"Rechercher"**

2. **Recherche instantanée** (si activée) :
   - Taper directement dans le tableau
   - Résultats en temps réel

### Modifier un étudiant

1. Cliquer sur l'icône **✏️ (Modifier)** sur la ligne de l'étudiant
2. Modifier les données
3. Cliquer sur **"Enregistrer les modifications"**

### Supprimer un étudiant

1. Cliquer sur l'icône **🗑️ (Supprimer)**
2. **Confirmer** la suppression
3. L'étudiant est supprimé et l'effectif de la classe est mis à jour

### Consignes importantes

- ⚠️ La suppression est **irréversible**
- 📌 L'email doit être **unique** (si fourni)
- 📞 Vérifier le format du téléphone
- 📅 La date de naissance doit être avant aujourd'hui

---

## 🏫 Gestion des classes

### Accès
Menu → **Classes** (Administrateur/Scolarité)

### Ajouter une classe

1. Cliquer sur **"+ Ajouter une classe"**
2. Remplir :
   - Nom de la classe
   - Filière (ex: Informatique)
   - Niveau (L1, L2, L3, Master)
   - Effectif maximum
3. Cliquer **"Enregistrer"**

### Consulter les classes

- Voir la liste avec effectifs actuels
- L'effectif se met à jour automatiquement

### Modifier une classe

1. Cliquer sur l'icône **✏️**
2. Modifier les données
3. Cliquer **"Enregistrer"**

---

## ⭐ Gestion des notes

### Accès
Menu → **Notes** (Enseignants et Admin)

### Saisir des notes

#### Pour un enseignant
1. Aller à **Notes**
2. Sélectionner une classe et un module
3. Pour chaque étudiant, saisir :
   - **CC** (Contrôle Continu) : 0-20
   - **TP** (Travaux Pratiques) : 0-20
   - **Examen** : 0-20
4. La **moyenne** se calcule automatiquement :
   - **Moyenne = CC×30% + TP×30% + Examen×40%**
5. Cliquer **"Enregistrer"**

#### La mention s'attribue automatiquement
- 18-20 : Excellent
- 16-17 : Très Bien
- 14-15 : Bien
- 12-13 : Assez Bien
- 10-11 : Passable
- 0-9 : Ajourné

#### La décision s'attribue automatiquement
- ≥ 10 : **Validé**
- < 10 : **Ajourné**

### Consulter les notes

1. Aller à **Notes**
2. Sélectionner classe/module
3. Voir le tableau avec toutes les notes
4. Les notes sont **triées par classement**

### Modifier des notes

1. Cliquer sur le **crayon** d'une note
2. Modifier les valeurs
3. Cliquer **"Enregistrer"**
4. Les calculs se font automatiquement

---

## 💳 Gestion des paiements

### Accès
Menu → **Paiements** (Administrateur/Scolarité)

### Ajouter un paiement

1. Cliquer **"+ Ajouter un paiement"**
2. Sélectionner l'étudiant
3. Saisir :
   - Montant total à payer
   - Montant payé
   - Date du paiement
   - Mode (Cash, Virement, Chèque, etc.)
4. Le **reste à payer** se calcule automatiquement
5. Cliquer **"Enregistrer"**

### Consulter l'historique

1. Aller à **Paiements** → **Historique**
2. Voir tous les paiements par étudiant
3. Filtrer par date, statut, montant

### États de paiement

- **En attente** : 0 FCFA payé
- **Partiel** : Montant payé < Total
- **Payé** : Montant payé = Total

### Éditer un paiement

1. Cliquer sur **✏️**
2. Modifier les données
3. Les calculs se mettent à jour automatiquement

### Générer une quittance

1. Cliquer sur **🖨️ (Imprimer)**
2. La quittance s'affiche
3. Imprimer ou enregistrer en PDF

---

## 📅 Emploi du temps

### Accès
Menu → **Emploi du temps** (Administrateur)

### Ajouter une séance

1. Cliquer **"+ Ajouter une séance"**
2. Saisir :
   - Jour de la semaine
   - Heure de début / Heure de fin
   - Salle
   - Classe
   - Enseignant
   - Module
   - Année universitaire
3. L'application vérifie les **conflits** automatiquement
4. Cliquer **"Enregistrer"**

### Vérifications automatiques

⚠️ L'application empêche :
- Un enseignant sur 2 cours au même moment
- Une salle réservée pour 2 cours simultanément
- Une classe avec 2 cours au même moment

### Consulter l'emploi du temps

1. Aller à **Emploi du temps** → **Affichage**
2. Filtrer par :
   - Classe
   - Enseignant
   - Jour de la semaine
3. Voir l'horaire complet

---

## 📈 Statistiques

### Accès
Menu → **Statistiques** (Administrateur)

### Graphiques disponibles

1. **Répartition des étudiants par classe**
   - Diagramme en camembert
   - Nombre par classe

2. **Répartition par sexe**
   - Nombre d'étudiants M/F

3. **Paiements mensuels**
   - Montants payés par mois
   - Courbe de tendance

4. **Taux de réussite par classe**
   - Pourcentage de réussite
   - Comparaison inter-classes

### Exporter les données

- 📊 **Excel** : Cliquer sur "Exporter"
- 📄 **PDF** : Cliquer sur "Imprimer"
- 🖼️ **Image** : Cliquer sur "Télécharger"

---

## ❓ Foire aux questions

### Q1 : Comment réinitialiser mon mot de passe ?
**R** : Contactez votre administrateur qui peut réinitialiser votre mot de passe.

### Q2 : Je vois "Accès refusé", que faire ?
**R** : Vous n'avez pas les permissions pour ce module. Contactez votre administrateur.

### Q3 : Le matricule s'est réaffecté, est-ce normal ?
**R** : Non, les matricules sont uniques et ne changent pas. Si c'est le cas, contactez l'administrateur.

### Q4 : Puis-je modifier une note enregistrée ?
**R** : Oui, vous pouvez modifier une note même après l'enregistrement initial.

### Q5 : Comment générer un relevé de notes pour un étudiant ?
**R** : Aller à **Relevés** → Sélectionner l'étudiant et l'année → **Générer**

### Q6 : L'effectif de ma classe ne se met pas à jour ?
**R** : Vérifier que les inscriptions sont bien enregistrées. L'effectif se met à jour automatiquement lors de chaque inscription/suppression.

### Q7 : Comment supprimer un paiement ?
**R** : Cliquer sur 🗑️ et confirmer. Attention : suppression irréversible.

### Q8 : Puis-je voir les notes de mes étudiants ?
**R** : Cela dépend de votre rôle. Enseignant : vos modules uniquement. Admin/Scolarité : tous les modules.

### Q9 : Comment changer la classe d'un étudiant ?
**R** : Aller à **Modifier l'étudiant** → Sélectionner la nouvelle classe → **Enregistrer**. Les effectifs se mettent à jour automatiquement.

### Q10 : Où voir mes connexions ?
**R** : Menu → **Profil** → **Journal des connexions** (si disponible)

---

## 💡 Conseils d'utilisation

1. **Sauvegardez régulièrement** votre travail
2. **Vérifiez les données** avant validation
3. **Utilisez la recherche** pour gagner du temps
4. **Consultez l'aide** en cas de doute
5. **Contactez l'administrateur** pour les problèmes techniques
6. **Changez votre mot de passe** régulièrement
7. **Déconnectez-vous** après chaque utilisation
8. **Utilisez des navigateurs à jour** pour la meilleure expérience

---

## 📞 Support utilisateur

Pour toute question :
1. Consulter ce manuel
2. Voir la **FAQ** ci-dessus
3. Consulter le **README.md**
4. Contacter votre **administrateur**
5. Contacter votre **formateur** : Mansour Dieng

---

**Version** : 1.0
**Dernière mise à jour** : 2024
**Institut** : ENSUP-AFRIQUE
