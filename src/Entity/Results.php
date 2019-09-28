<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultsRepository")
 */
class Results
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $studentId;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /** @ORM\Column(type="string", columnDefinition="ENUM('bardzo dobry', 'dobry', 'dostateczny', 'dopuszczający', 'niedostateczny')") */
    private $grade;

    /**
     * @ORM\Column(type="string")
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }
}
