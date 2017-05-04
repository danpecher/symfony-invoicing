<?php

namespace AppBundle\Form;

use AppBundle\Entity\Invoice;
use AppBundle\Entity\User;
use AppBundle\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class InvoiceForm extends AbstractType
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var User
     */
    private $user;

    /**
     * InvoiceForm constructor.
     *
     * @param ClientRepository $clientRepository
     * @param TokenStorage $tokenStorage
     */
    public function __construct(ClientRepository $clientRepository, TokenStorage $tokenStorage)
    {
        $this->clientRepository = $clientRepository;
        $this->user             = $tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, ['label' => 'Číslo faktury'])
            ->add('client', EntityType::class, [
                'class'        => 'AppBundle\Entity\Client',
                'choices'      => $this->clientRepository->findAllForUser($this->user->getId()),
                'choice_label' => 'name',
                'label'        => 'Klient',
                'placeholder'  => 'Vyberte klienta ...',
            ])
            ->add('currency', ChoiceType::class, [
                'label'   => 'Měna',
                'choices' => [
                    'CZK' => 'CZK',
                    'EUR' => 'EUR',
                    'USD' => 'USD',
                ]
            ])
            ->add('issuedAt', DateType::class, [
                'label' => 'Datum vystavení',
            ])
            ->add('paymentDue', DateType::class, [
                'label' => 'Datum splatnosti',
            ])
            ->add('items', CollectionType::class, [
                'label'        => 'Položky faktury',
                'entry_type'   => InvoiceItemForm::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}