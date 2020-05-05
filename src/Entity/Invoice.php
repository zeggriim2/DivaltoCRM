<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @ApiResource(
 *     subresourceOperations={
 *          "api_customers_invoices_get_subresource"={
 *              "method"="GET",
 *              "normalization_context"={"groups"={"invoice_sub"}}
 *          }
 *     },
 *     attributes={
 *          "pagination_enabled"=true,
 *          "pagination_item_per_page"=20,
 *          "order":{"sendAt": "desc"}
 *     },
 *     normalizationContext={"groups"={"invoices_read"}}
 * )
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read","customers_read", "invoice_sub"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     */
    private $sendAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invoices_read"})
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     */
    private $chrono;


    /**
     * Permet de récupérer le User à qui appartient finalement la facture
     * @Groups({"invoices_read", "invoice_sub"})
     * @return User
     */
    public function getUser(): User {
        return $this->customer->getUser();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
