NOTES DE CONCEPTION DE LA GESTION DES CAMPS
=
***

Description
-

Le niveau de camps est dependant de la structure, ainsi:
>
    1. activité nationale ouverte uniquement à l'équipe nationale
    2. activité nationale ouverte aux nationaux et regionaux 
    3. activité nationale ouverte aux chefs 
    4. activité nationale ouverte à tous les scouts
    5. activité regionale ouverte uniquement à l'equipe regionale
    6. activité regionale ouverte uniquement aux CD
    7. activité regionale ouverte uniquement aux chefs 
    8. activité regionale ouverte à tous les scouts 
    9. activité de district ouverte uniquement à l'equipe de district
    10. activité de district ouverte aux CG
    11. activité de district ouverte aux chefs 
    12. activité de district ouverte à tous les scouts 
    13. activité de groupe ouverte uniquement aux chefs 
    14. activité de groupe ouverte à tous les scouts


Entity
-
>
> **Type de camp**: [select] (initiation - progesseion - formation - loisir)
 **Nom du camp**: [string]  
> **Date debut du camp**: [date]  
> **Date fin**: [date]  
> **Lieu du camping**: [string]  
> **Situation géograpique du site**: [text]  
> **Description du camp**: [text]  
> **Coordonnées**: [string] (latittude - longetitude)
> **Proprietaire du site d'accueil**: [string] (nom & prenoms - fonction/profession - contact - copie decharge autorisation)  
> **Niveau du camp**: [select]
> **Groupe**: [relation]  
> **CreatedAt**: [datetime]  
> **UpdatedAt**: [datetime]  