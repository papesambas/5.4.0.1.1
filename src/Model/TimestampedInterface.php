<?php

namespace App\Model;

interface TimestampedInterface
{
    public function getUpdatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt);
}