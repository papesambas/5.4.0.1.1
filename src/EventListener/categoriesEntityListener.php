<?php

namespace App\EventListener;

use App\Entity\Categories;
use App\Entity\Classes;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use function PHPUnit\Framework\throwException;

use Symfony\Component\String\Slugger\SluggerInterface;

class categoriesEntityListener
{

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Categories $categories, LifecycleEventArgs $arg): void
    {
        /*$user = $this->Securty->getUser();
        if ($user === null) {
            throw new \LogicException('User cannot be null here ...');
        }*/

        $categories
            //->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getCatégoriesSlug($categories));
    }

    private function getCatégoriesSlug(Categories $categories): string
    {
        $slug = mb_strtolower($categories->getNom() . '-' . $categories->getNiveau(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}