<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Participant;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payment
 *
 * @ORM\Table(name="payment", indexes={@ORM\Index(name="fk_payment_participant1_idx", columns={"participant_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=true, options={"default"=NULL})
     * @Assert\NotBlank
     */
    private $amount;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $createdAt;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $updatedAt;

    /**
     * @var Participant
     *
     * @ORM\ManyToOne(targetEntity="Participant", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="participant_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank
     */
    private $participant;

    /**
     * @var bool
     *
     * @ORM\Column(name="hide_identity", type="boolean", nullable=true, options={"default"=0})
     */
    private $hideIdentity;

    /**
     * @var bool
     *
     * @ORM\Column(name="hide_amount", type="boolean", nullable=true, options={"default"=0})
     */
    private $hideAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="card_name", type="string", nullable=true, options={"default"=NULL})
     * @Assert\NotBlank
     */
    private $cardName;

    /**
     * @var int
     *
     * @ORM\Column(name="card_number", type="bigint", nullable=true, options={"default"=NULL})
     * @Assert\NotBlank
     */
    private $cardNumber;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="card_expiration_date", type="datetime", nullable=true, options={"default"=NULL})
     * @Assert\NotBlank
     */
    private $cardExpirationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="card_cvv", type="integer", nullable=true, options={"default"=NULL})
     * @Assert\NotBlank
     */
    private $cardCVV;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime('now');

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime('now');

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getHideIdentity(): ?bool
    {
        return $this->hideIdentity;
    }

    public function setHideIdentity(?bool $hideIdentity): self
    {
        $this->hideIdentity = $hideIdentity;

        return $this;
    }

    public function getHideAmount(): ?bool
    {
        return $this->hideAmount;
    }

    public function setHideAmount(?bool $hideAmount): self
    {
        $this->hideAmount = $hideAmount;

        return $this;
    }

    public function getCardName(): ?string
    {
        return $this->cardName;
    }

    public function setCardName(?string $cardName): self
    {
        $this->cardName = $cardName;

        return $this;
    }

    public function getCardNumber(): ?int
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?int $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardExpirationDate(): ?\DateTimeInterface
    {
        return $this->cardExpirationDate;
    }

    public function setCardExpirationDate(?\DateTimeInterface $cardExpirationDate): self
    {
        // $this->cardExpirationDate = new \DateTime(date('Y-m-d H:i:s', strtotime($cardExpirationDate)));
        $this->cardExpirationDate = $cardExpirationDate;

        return $this;
    }

    public function getCardCVV()
    {
        return $this->cardCVV;
    }

    public function setCardCVV($cardCVV): self
    {
        $this->cardCVV = $cardCVV;

        return $this;
    }
}
