<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $serial_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $colour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $license_plate;

    /**
     * @ORM\Column(type="float")
     */
    private $mileage;

    /**
     * @ORM\Column(type="date")
     */
    private $purchase_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $rental_price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $available;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_category;

    /**
     * @ORM\Column(type="integer")
     */
    private $daily_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getSerialNumber(): ?int
    {
        return $this->serial_number;
    }

    public function setSerialNumber(int $serial_number): self
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(string $colour): self
    {
        $this->colour = $colour;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->license_plate;
    }

    public function setLicensePlate(string $license_plate): self
    {
        $this->license_plate = $license_plate;

        return $this;
    }

    public function getMileage(): ?float
    {
        return $this->mileage;
    }

    public function setMileage(float $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_date): self
    {
        $this->purchase_date = $purchase_date;

        return $this;
    }

    public function getRentalPrice(): ?int
    {
        return $this->rental_price;
    }

    public function setRentalPrice(int $rental_price): self
    {
        $this->rental_price = $rental_price;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(?bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getIdCategory(): ?int
    {
        return $this->id_category;
    }

    public function setIdCategory(int $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getDailyPrice(): ?int
    {
        return $this->daily_price;
    }

    public function setDailyPrice(int $daily_price): self
    {
        $this->daily_price = $daily_price;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
