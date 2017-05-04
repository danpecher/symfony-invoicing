<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PreFlush;

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
     * @OneToMany(targetEntity="InvoiceItem", mappedBy="invoice", cascade={"persist", "remove"}, orphanRemoval=true)
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
     * @ORM\Column(type="boolean")
     */
    private $sent = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cancelled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid = false;

    /**
     * Invoice constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->issuedAt = new \DateTime();
        $this->paymentDue = new \DateTime();
    }

    /**
     * @PreFlush
     */
    public function calculateTotalOnPrePersist()
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

        $this->setTotalCents($total * 100);
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

    public function addItem(InvoiceItem $item)
    {
        $this->items->add($item);
        $item->setInvoice($this);

        return $this;
    }

    public function removeItem(InvoiceItem $item)
    {
        $this->items->removeElement($item);
        $item->setInvoice(null);
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
        return $this->totalCents / 100;
    }

    /**
     * @param mixed $totalCents
     */
    public function setTotalCents($totalCents)
    {
        $this->totalCents = $totalCents * 100;
    }

    /**
     * @return mixed
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * @param mixed $sent
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    }

    /**
     * @return mixed
     */
    public function getCancelled()
    {
        return $this->cancelled;
    }

    /**
     * @param mixed $cancelled
     */
    public function setCancelled($cancelled)
    {
        $this->cancelled = $cancelled;
    }

    /**
     * @return mixed
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param mixed $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }
}