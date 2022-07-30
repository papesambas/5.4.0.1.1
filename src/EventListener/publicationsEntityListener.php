<?php

namespace App\EventListener;

use App\Entity\Publications;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
use function PHPUnit\Framework\throwException;

use Symfony\Component\String\Slugger\SluggerInterface;

class publicationsEntityListener
{

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Publications $publications, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            throw new \LogicException('User cannot be null here ...');
        }

        $author = $user;
        $publications
            ->setAuthor($author)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getPublicationsSlug($publications))
            ->setPublishedAt(new \DateTimeImmutable('now'));
    }

    private function getPublicationsSlug(Publications $publications): string
    {
        $slug = mb_strtolower($publications->getTitre() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}