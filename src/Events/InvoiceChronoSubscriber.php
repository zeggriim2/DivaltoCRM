<?php

namespace App\Events;

use App\Entity\Invoice;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InvoiceChronoSubscriber implements EventSubscriberInterface{

    private $security;
    private $repoInvoice;

    public function __construct(Security $security, InvoiceRepository $repoInvoice)
    {
        $this->security = $security;
        $this->repoInvoice = $repoInvoice;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setChronoForInvoice', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setChronoForInvoice(ViewEvent $event){
        $invoice = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($invoice instanceof Invoice && $method === "POST"){

            // J'ai besoin de récupérer l'utilisateur connecté
            $user = $this->security->getUser();

            // j'ai besoin du répository des factures (InvoiceRepository)
            $chronoIncrement = $this->repoInvoice->findNextChrono($user); // Retour du chrono incrementé de +1

            $invoice->setChrono($chronoIncrement);

            // A déplacer dans une classe dédiée
            // Ajouté la date si celle-ci n'est pas renseignée.
            if(empty($invoice->getSendAt())){
                $invoice->setSendAt(new \DateTime());
            }
        }
    }
}