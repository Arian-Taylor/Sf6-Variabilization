<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Object\CustomTranslationObject;

class AppSubscriber implements EventSubscriberInterface
{
    private $customtranslationobject;

    public function __construct(CustomTranslationObject $customtranslationobject)
    {
        $this->customtranslationobject = $customtranslationobject;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->customtranslationobject->initStaticProperty() ;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}