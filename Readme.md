# BJ Group Orders
## But du module
Ce module permet de regrouper visuellement des commandes en utilisant les groupes de clients.  
Et ainsi pouvoir visualiser les commandes que vous devez préparer par groupe.  
Vous pourrez ensuite rapidement préciser qu'une commande a été préparée et est disponible en cliquant sur le bouton prévu à cet effet dans la liste des commandes affichées.
## Configuration du module
La première chose à faire est de créer les groupes de clients qui vous conviennent pour regrouper vos commandes.  
Vous pourriez, par exemple, vouloir regrouper vos clients dans des zones géographiques, ou par société.
Prenons comme exemple un regroupement par société.
 1. Commencer par créer les groupes de clients ("Paramètres de la boutique" > "Clients" > Onglet "Groupes")
 2. Cliquer sur le bouton "Ajouter un groupe de clients"
 3. Pour les besoins de ce module, seul un nom suffit, pour notre exemple créons les groups suivants :
    1. Mountain View
    2. Cupertino
 4. Il faut ensuite catégoriser vos clients dans les bons groupes. 
    1. Pour ce faire, il suffit d'aller sur la liste client ("Clients" > "Clients").
    2. Cliquer ensuite sur l'icône en forme de crayon pour venir modifier le client voulu.
    3. Laisser les groupes actuels (Visiteurs, Clients ...) mais ajouter un des groupes créés (Cupertino ou Mountain View)
    4. Enregistrer
 5. Nous allons ensuite configurer le module. Pour ce faire :
    1. "Modules" > "Gestionnaire de modules"
    2. Rechercher le module "BJ"
    3. Cliquer sur me bouton "Configurer"
    4. Choisissez les groupes de clients permettant de regrouper les commandes à afficher (Nous allons, pour l'exemple donc cocher nos deux groupes précédemment créés).
    Ce faisant, il y aura donc 2 groupes affichant les commandes.
    5. Pour éviter d'afficher toutes les commandes (mêmes celles déjà traitées), il faut choisir quels états de commande seront affichés.
    (Seules les commandes dans un des états cochés seront affichées)
    6. Pensez à bien cocher les états de commande qui vous permettent de savoir quelles sont les commandes à préparer.
    7. Pensez à sauvegarder.
## Visualiser les commandes à préparer
Pour visualiser les commandes regroupées et ainsi vous simplifier la vie, il suffit de cliquer sur "Commandes" > "Par groupes".  
Vous visualiserez ainsi seules les commandes dans les états choisis lors de la configuration du module.  
Et ces commandes seront regroupées par groupe.  
Attention, si un client est dans plusieurs des groupes chosis, leurs commandes apparaitront dans tous les groupes.  
Vous visualiserez facilement :
 * Le nom du client
 * Le contenu de la commande
 * Le montant de la commande
 * L'état de la commande
 * Et la date de la commande
En cliquant sur le bouton "Disponible", la commande disparaitra de la liste et passera au statut "Disponible".  
En utilisant ingénieusement le fonctionnement des status de commande, vous pourrez avertir automatiquement le client par email que sa commande est prête.
## Avertir le client que sa commande est disponible automatiquement
