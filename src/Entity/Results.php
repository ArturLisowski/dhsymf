<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultsRepository")
 */
class Results
{

    const GRADE5 = 'bardzo dobry';
    const GRADE4 = 'dobry';
    const GRADE3 = 'dostateczny';
    const GRADE2 = 'dopuszczający';
    const GRADE1 = 'niedostateczny';

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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setStudentId(int $value)
    {
        $this->studentId = $value;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setPoints(int $value)
    {
        $this->points = $value;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * @param string $value
     * @return $this
     * @throws \Exception
     */
    public function setGrade(string $value)
    {
        if (!in_array($value, [
            Results::GRADE5,
            Results::GRADE4,
            Results::GRADE3,
            Results::GRADE2,
            Results::GRADE1,
        ], true)) {
            throw new \Exception('Result - setGrade incorect value :' . $value, 400);
        }

        $this->grade = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGrade(): string
    {
        return $this->grade;
    }
}
