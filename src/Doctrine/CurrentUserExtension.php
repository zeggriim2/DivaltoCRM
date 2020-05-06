<?php

namespace App\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface{


    private $security;
    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $checker)
    {
        $this->security = $security;
        $this->auth = $checker;
    }

    private function AddWhere(QueryBuilder $queryBuilder, string $resourceClass){
        //Obtenir l'utilisateur connecté    
        $user =  $this->security->getUser();
                
        // Si on demande des invoices ou des customers alors, agir sur la requête pour qu'elle tienne compte de l'utilisateur connecté
        if(
            ($resourceClass === Invoice::class || $resourceClass === Customer::class)
            && !$this->auth->isGranted('ROLE_ADMIN') 
            && $user instanceof User
            )
            {
            $rootAlias = $queryBuilder->getRootAlias()[0];
            if ($resourceClass === Customer::class){
                $queryBuilder->andWhere("$rootAlias.user = :user");
            }else if($resourceClass === Invoice::class){
                $queryBuilder->join("$rootAlias.customer", "c")
                            ->andWhere("c.user = :user");
            }
            $queryBuilder->setParameter('user', $user);
        }
    }


    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null){
        $this->AddWhere($queryBuilder,$resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []){
        $this->AddWhere($queryBuilder,$resourceClass);
    }
}