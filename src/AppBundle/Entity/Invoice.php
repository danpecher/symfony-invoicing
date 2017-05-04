<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="invoices")
 * @HasLifecycleCallbacks
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $issuedAt;

    /**
     * @ORM\Column(type="string")
     */
    private $number;

    /**
     * @ManyToOne(targetEntity="Client")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $client;

    /**
     * @ORM\Column(type="date")
     */
    private $paymentDue;

    /**
     * @OneToMany(targetEntity="InvoiceItem", mappedBy="invoice")
     */
    private $items;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @OneToOne(targetEntity="User")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalCents;

    /**
     * Invoice constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->issuedAt = new \DateTime();
        $this->paymentDue = new \DateTime();
    }

    /** @PrePersist */
    public function calculateTotalOnPrePersist()
    {
        $this->calculateTotal();
    }

    /** @PreUpdate */
    public function calculateTotalOnPreUpdate()
    {
        $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $total = 0;
        /** @var InvoiceItem $item */
        foreach ($this->items as $item) {
            $total += $item->getQuantity() * $item->getPricePerUnitCents();
        }

        $this->setTotalCents($total);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIssuedAt()
    {
        return $this->issuedAt;
    }

    /**
     * @param mixed $issuedAt
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getPaymentDue()
    {
        return $this->paymentDue;
    }

    /**
     * @param mixed $paymentDue
     */
    public function setPaymentDue($paymentDue)
    {
        $this->paymentDue = $paymentDue;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTotalCents()
    {
        return $this->totalCents;
    }

    /**
     * @param mixed $totalCents
     */
    public function setTotalCents($totalCents)
    {
        $this->totalCents = $totalCents;
    }

}