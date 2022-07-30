<?php

namespace App\EventListener;

use App\Entity\Etablissements;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use function PHPUnit\Framework\throwException;

use Symfony\Component\String\Slugger\SluggerInterface;

class etablissementsEntityListener
{

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Etablissements $etablissements, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        /*if ($user === null) {
            throw new \LogicException('User cannot be null here ...');
        }*/

        $etablissements
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getEtablissementsSlug($etablissements));
    }

    private function getEtablissementsSlug(Etablissements $etablissements): string
    {
        $slug = mb_strtolower($etablissements->getDesignation() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}