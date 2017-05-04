<?php

namespace AppBundle\Form;

use AppBundle\Entity\Invoice;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, ['label' => 'Číslo faktury'])
            ->add('client', EntityType::class, [
                'class'         => 'AppBundle\Entity\Client',
                'query_builder' => function (EntityRepository $e) {
                    return $e->createQueryBuilder('cl');
                },
                'choice_label'  => 'name',
                'label'         => 'Klient',
                'placeholder'   => 'Vyberte klienta ...',
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}