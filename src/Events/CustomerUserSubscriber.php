<?php
namespace App\Events;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class CustomerUserSubscriber implements EventSubscriberInterface{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ['setUserForCustomer', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForCustomer(ViewEvent $event){
        $customer = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();


        // On test si on est bien sur un Customer que l'on souhaite créer avec la méthode POST
        if ($customer instanceof Customer && $method === "POST"){
            //Choper l'utilisateur actuellement connecté
            $user = $this->security->getUser();
            
            //Assigner l'utilisateur au Customer qu'on est en train de créer
            $customer->setUser($user);
        }
        
    }
}