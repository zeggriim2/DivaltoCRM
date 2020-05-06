<?php

namespace App\Events;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber {
    // /**
    //  * @var RequestStack
    //  */
    // private $requestStack;

    // /**
    //  * @param RequestStack $requestStack
    //  */
    // public function __construct(RequestStack $requestStack)
    // {
    //     $this->requestStack = $requestStack;
    // }   

    public function updateJwtData(JWTCreatedEvent $event){
        // 1. On récupère l'utilisateur (pour savoir son firstname et lastname)
        $user = $event->getUser();

        //2. Enrichir les data
        $data = $event->getData();
        $data['firstname'] = $user->getFirstName();
        $data['lastname'] = $user->getLastName();
        
        $event->setData($data);
    }
}