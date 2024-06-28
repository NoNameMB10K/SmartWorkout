<?php

namespace App\Entity;

use App\Repository\ExerciseLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseLogRepository::class)]
class ExerciseLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nrReps = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNrReps(): ?int
    {
        return $this->nrReps;
    }

    public function setNrReps(int $nrReps): static
    {
        $this->nrReps = $nrReps;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
