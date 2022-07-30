<?php

namespace App\EventListener;

use App\Entity\Users;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use function PHPUnit\Framework\throwException;

use Symfony\Component\String\Slugger\SluggerInterface;

class usersEntityListener
{

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Users $users, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        /*if ($user === null) {
            throw new \LogicException('User cannot be null here ...');
        }*/

        $users
            ->setIscreatedAt(new \DateTimeImmutable('now'));
        //->setCreatedAt(new \DateTimeImmutable('now'))
        //->setSlug($this->getClassesSlug($classes))
    }

    /*private function getClassesSlug(Classes $classes): string
    {
        $slug = mb_strtolower($classes->getDesignation(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }*/
}