<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimesheetsRepository")
 * @ApiResource(iri="http://schema.org/Offer")
 */
class Timesheet implements \ArrayAccess
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="timesheets")
     */

    // private $employee;

    // public function getEmployee(): ?Employee
    // {
    //     return $this->employee_id;
    // }

    // public function setEmployee(?Employee $employee): self
    // {
    //     $this->employee_id = $employee;

    //     return $this;
    // }

    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $employee_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $pauze;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activities;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $materials;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hourly_rate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $transport_cost;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_accepted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employee_id;
    }

    public function setEmployeeId(int $employee_id): self
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    public function getRateId(): ?int
    {
        return $this->rate_id;
    }

    public function setRateId(int $rate_id): self
    {
        $this->rate_id = $rate_id;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPauze(): ?int
    {
        return $this->pauze;
    }

    public function setPauze(int $pauze): self
    {
        $this->pauze = $pauze;

        return $this;
    }

    public function getActivities(): ?string
    {
        return $this->activities;
    }

    public function setActivities(string $activities): self
    {
        $this->activities = $activities;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(?string $materials): self
    {
        $this->materials = $materials;

        return $this;
    }

    public function getHourlyRate(): ?int
    {
        return $this->hourly_rate;
    }

    public function setHourlyRate(?int $hourly_rate): self
    {
        $this->hourly_rate = $hourly_rate;

        return $this;
    }

    public function getTransportCost(): ?int
    {
        return $this->transport_cost;
    }

    public function setTransportCost(?int $transport_cost): self
    {
        $this->transport_cost = $transport_cost;

        return $this;
    }

    public function offsetExists($offset) {
        return isset($this->$offset);
    }

    public function offsetSet($offset, $value) {
        $this->$offset = $value;
    }

    public function offsetGet($offset) {
        return $this->$offset;
    }

    public function offsetUnset($offset) {
        $this->$offset = null;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->is_accepted;
    }

    public function setIsAccepted(?bool $is_accepted): self
    {
        $this->is_accepted = $is_accepted;

        return $this;
    }
}
