<?php

namespace KimaiPlugin\MaterialBundle\EventSubscriber;

use App\Entity\MetaTableTypeInterface;
use App\Entity\TimesheetMeta;
use App\Event\TimesheetMetaDefinitionEvent;
use App\Event\TimesheetMetaDisplayEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MetaFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            TimesheetMetaDefinitionEvent::class => ['loadTimesheetMeta', 200],
            TimesheetMetaDisplayEvent::class => ['loadTimesheetFields', 200],
        ];
    }

    private function getMetaField(): MetaTableTypeInterface
    {
        return (new TimesheetMeta())
            ->setName('material_bundle')
            ->setLabel('Material')
            ->setOptions(['label' => 'Material', 'help' => 'Bitte im Format: "<Menge> x <Artikel> <SN> <Netto-EK> <Netto-VK>" z.B.: 1 x TOSHIBA USB 250GB SN:xxx 44,99 € 55,99 €"'])
            ->setType(TextareaType::class)
            ->setIsVisible(true);
    }

    public function loadTimesheetMeta(TimesheetMetaDefinitionEvent $event)
    {
        $event->getEntity()->setMetaField($this->getMetaField());
    }

    public function loadTimesheetFields(TimesheetMetaDisplayEvent $event)
    {
        $event->addField($this->getMetaField());
    }
}
