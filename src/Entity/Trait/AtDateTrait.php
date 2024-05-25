<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait AtDateTrait
{
  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $updatedAt = null;

  #[ORM\Column]
  private ?int $isArchived = 0;

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  public function getIsArchived(): ?int
  {
    return $this->isArchived;
  }

  public function setIsArchived(int $isArchived): static
  {
    $this->isActive = $isArchived;

    return $this;
  }
}
