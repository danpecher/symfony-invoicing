<?php

namespace AppBundle\Form;

use AppBundle\Entity\InvoiceItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('unit', ChoiceType::class, [
                'choices' => [
                    'ks' => 'ks',
                    'kg' => 'kg',
                ]
            ])
            ->add('title', TextType::class)
            ->add('pricePerUnitCents', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => InvoiceItem::class,
        ]);
    }
}