# BJ Group Orders
## But du module
Ce module permet de regrouper visuellement des commandes en utilisant les groupes de clients.  
Et ainsi pouvoir visualiser les commandes que vous devez préparer par groupe.  
Vous pourrez ensuite rapidement préciser qu'une commande a été préparée et est disponible en cliquant sur le bouton prévu à cet effet dans la liste des commandes affichées.
## Configuration du module
La première chose à faire est de créer les groupes de clients qui vous conviennent pour regrouper vos commandes.  
Vous pourriez, par exemple, vouloir regrouper vos clients dans des zones géographiques, ou par société.
Prenons comme exemple un regroupement par société.
 1. Commencer par créer les groupes de clients
 !["Paramètres de la boutique" > "Clients"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_1.jpg?raw=true)  
 ![Onglet "Groupes"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_2.jpg?raw=true)
 2. Cliquer sur le bouton
 !["Ajouter un groupe de clients"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/add_client.jpg?raw=true)
 3. Pour les besoins de ce module, seul un nom suffit, pour notre exemple créons les groups suivants :
    1. Mountain View  
    ![Mountain View](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/new_group.jpg?raw=true)
    2. Cupertino  
 ![Liste de groupes](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/group_list.jpg?raw=true)
 4. Il faut ensuite catégoriser vos clients dans les bons groupes. 
    1. Pour ce faire, il suffit d'aller sur la liste client  
    !["Clients" > "Clients"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_3.jpg?raw=true)
    2. Cliquer ensuite sur l'icône en forme de crayon pour venir modifier le client voulu.
    ![Modifier client](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/update.jpg?raw=true)
    3. Laisser les groupes actuels (Visiteurs, Clients ...) mais ajouter un des groupes créés (Cupertino ou Mountain View)  
    ![Groupes client](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/groupq.jpg?raw=true)
    4. Enregistrer ![Bouton](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/save.jpg?raw=true)
 5. Nous allons ensuite configurer le module. Pour ce faire :
    1. "Modules" > "Gestionnaire de modules"  
    ![Accès](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_4.jpg?raw=true)
    2. Rechercher le module "BJ"  
    ![Module](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/module.jpg?raw=true)
    3. Cliquer sur le bouton "Configurer"
    4. Choisissez les groupes de clients permettant de regrouper les commandes à afficher (Nous allons, pour l'exemple donc cocher nos deux groupes précédemment créés).
    Ce faisant, il y aura donc 2 groupes affichant les commandes.
    5. Pour éviter d'afficher toutes les commandes (mêmes celles déjà traitées), il faut choisir quels états de commande seront affichés.
    (Seules les commandes dans un des états cochés seront affichées)
    6. Pensez à bien cocher les états de commande qui vous permettent de savoir quelles sont les commandes à préparer.
    7. Pensez à sauvegarder.  
    ![Config](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/config.jpg?raw=true)
## Visualiser les commandes à préparer
Pour visualiser les commandes regroupées et ainsi vous simplifier la vie, il suffit de cliquer sur  
!["Commandes" > "Par groupes"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_5.jpg?raw=true)  
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
![Liste commandes groupées](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/commandes_groupees.jpg?raw=true)
## Avertir le client que sa commande est disponible automatiquement
Pour faire ça de manière simple, nous allons utiliser un modèle d'email existant.  
Nous allons utiliser le modèle "Package in transit" qui initialement permet de préciser au client que sa commande a été envoyée.  
Nous allons commencer par modifier le titre et le contenu du message :
 1. Tout cela se passe dans les traductions  
 !["International" > "Traduction"](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/menu_trad.jpg?raw=true)
 2. Choisissez les options suivantes:  
 ![Options](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/options.jpg?raw=true)
 3. Modifier le titre, par exemple :  
 ![Commande prete](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/commande_prete.jpg?raw=true)
 4. Enregistrer
 5. Retourner à l'étape 1
 6. Choisir ces nouvelles options :  
 ![Options 2](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/options_2.jpg?raw=true)
 7. Chercher et cliquer sur "in_transit"  
 ![in transit](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/in_transit.jpg?raw=true)
 8. Modifier le contenu dans le HTML et le texte brut pour y mettre le message à envoyer au client  
 ![message](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/message.jpg?raw=true)
 9. Enregistrer
 
Ces premières étapes nous ont permis de modifier le titre et le message qui sera envoyé aux clients pour l'email 'in_transit'.  
Nous allons maintenant configurer le statut de commande "Disponible" pour envoyer automatiquement cet email au moment où la commande passe dans cet état.  
 1. Se rendre dans la liste des états de commandes  
 ![menu etats](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/param_commandes.jpg?raw=true)  
 ![onglet etats](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/onglet_etat.jpg?raw=true)
 2. Modifier l'état "Disponible"  
 ![etat dispo](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/etat_dispo.jpg?raw=true)
 3. Renseigner les informations comme ceci :  
 ![etat modifie](https://github.com/BrunoJunior/bjgrouporders/blob/master/documentation/etat_modifie.jpg?raw=true)
 4. Enregistrer
 
 Et voilà ! Dans la liste des commandes regroupées, lorsque vous cliquerez sur le bouton "Disponible", la commande changera d'état et un email sera envoyé au client.
