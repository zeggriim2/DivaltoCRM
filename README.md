# DivaltoCRM

Ceci est un projet pour pouvoir testé API Platform avec Symfony 4

Le but du projet est d'afficher la liste des factures clients de l'utilisateur associé.

# Liste des Web Service REST 
![Api Customer](https://user-images.githubusercontent.com/51760726/81479360-ff6b8000-9222-11ea-97ea-6bd7f410a15d.png)
![Api invoice](https://user-images.githubusercontent.com/51760726/81479361-01354380-9223-11ea-9533-9c103962c77a.png)
![Api User](https://user-images.githubusercontent.com/51760726/81479363-02667080-9223-11ea-8102-def411c07796.png)

Pour sécuriser les échanges avec le WebService, un système de token JWT a été mis en place (https://jwt.io/).

On indique l’email et le mot de passe d’un utilisateur valide. Un token nous est alors renvoyé : nous devons le renseigner dans l’authentification de la requête que l’on souhaite ensuite interroger.

![ApiCheckLogin](https://user-images.githubusercontent.com/51760726/81479539-1fe80a00-9224-11ea-9f06-dd99c7e9d092.png)

# Liste des clients 
![EcranLisCustomerSearch](https://user-images.githubusercontent.com/51760726/81479779-cda7e880-9225-11ea-98fd-e5a8d7a10a07.png)

![EcranLisCustomerPag](https://user-images.githubusercontent.com/51760726/81479767-aea95680-9225-11ea-9b53-2e424d57147b.png)

Nous affichons la liste des clients de l'utilisateur connecté.
Un système en haut de la liste permet de rechercher le prénom, le nom, l’email du client ainsi le nom d'entreprise.
En fonction du nombre de clients à afficher, un système de pagination réalisé en JS indique le nombre de pages total.
La liste totale des clients est divisée en plusieurs pages, ce système de pagination a été réalisé en JS. Le nombre de pages à afficher correspond au nombre de clients total divisé par le nombre de clients à afficher par page. Un autre système de pagination aurait pu être mis en place avec des interrogations de Web Service, si le Web Service était configuré en pagination lui-même.


# Liste des factures 
![2020-05-09 18_16_34-Window](https://user-images.githubusercontent.com/51760726/81479610-84a36480-9224-11ea-8b7f-181938dc09a9.png)

Nous affichons la liste des factures des clients de l'utilisateur connecté.

Un système en haut de la liste permet de rechercher le prénom, le nom, le montant ainsi que les différents statuts de la facture.

Un système de pagination a été réalisé comme celui des Customers.

