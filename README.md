# DivaltoCRM

Ceci est un projet pour pouvoir testé API Platform avec Symfony 4

Le but du projet est d'afficher la liste des factures clients de l'utilisateur associé.

# Liste des Web Service REST 
![Api Customer](https://user-images.githubusercontent.com/51760726/81479360-ff6b8000-9222-11ea-97ea-6bd7f410a15d.png)
![Api invoice](https://user-images.githubusercontent.com/51760726/81479361-01354380-9223-11ea-9533-9c103962c77a.png)
![Api User](https://user-images.githubusercontent.com/51760726/81479363-02667080-9223-11ea-8102-def411c07796.png)

Les requètes sont sécurisées par un système de token JWT (https://jwt.io/)

On indique l'email et le mot de passe de l'utilisateur, il nous renvoi un token que l'on doit renseigner dans l'auth de la requête que l'on souhaite ensuite intéroger.

![ApiCheckLogin](https://user-images.githubusercontent.com/51760726/81479539-1fe80a00-9224-11ea-9f06-dd99c7e9d092.png)

# Liste des clients 
![EcranLisCustomerSearch](https://user-images.githubusercontent.com/51760726/81479779-cda7e880-9225-11ea-98fd-e5a8d7a10a07.png)

![EcranLisCustomerPag](https://user-images.githubusercontent.com/51760726/81479767-aea95680-9225-11ea-9b53-2e424d57147b.png)

Nous affiche la liste des clients de l'utilisateur connecté.

Un système de recherche en haut permet de faire des recherche sur le prénom du client, du nom du client, le nom d'entreprise et l'email du client.

Un système de pagination réaliser en JS qui compte le nombre de client récupère au total. Il est divisé par le nombre de client que l'on veut affiché à l'écran. (Un autre système de pagination aurait pu être mis en place avec des intérogations de Web Service, si le Web Service est configurer en pagination lui même).

# Liste des factures 
![2020-05-09 18_16_34-Window](https://user-images.githubusercontent.com/51760726/81479610-84a36480-9224-11ea-8b7f-181938dc09a9.png)

Nous affiche la liste de facture des clients de l'utilisateur connecté.

Un système de recherche en haut permet de faire des recherche sur le prénom du client, du nom du client, le montant de la facture et les différent statut de la facture.

Un systeme de pagination été réaliser comme celui des Customers.
