<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
 *          "pagination_enabled"=false,
 *          "pagination_item_per_page"=20,
 *          "order":{"sendAt": "desc"}
 *     },
 *     normalizationContext={"groups"={"invoices_read"}},
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 * @ApiFilter(OrderFilter::class, properties={"amount", "sentAt"})
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
     * @Assert\NotBlank(message="Le montant de la facture est obligaoire")
     * @Assert\Type(type="numeric", message="Le montant de la facture doit être du numerique !")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     * @Assert\DateTime(message="La date doit être au format YYYY-MM-DD")
     * @Assert\NotBlank(message="La date d'envoi doit être renseignée.")
     */
    private $sendAt;
  
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     * @Assert\NotBlank(message="Le statut de la facture est obligatoire")
     * @Assert\Choice(choices={"SENT", "PAID", "CANCELLED"}, message="Le status doit etre SENT, PAID ou CANCELLED.")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invoices_read"})
     * @Assert\NotBlank(message="Le client de la facture est renseignée")
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read", "invoice_sub"})
     * @Assert\NotBlank(message="Le faut absolument un chrono pour la facture")
     * @Assert\Type(type="integer", message="Le chrono doit être un nombre.")
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

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt($sendAt): self
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
