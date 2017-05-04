<?php

namespace AppBundle\Form;

use AppBundle\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Jméno'])
                ->add('street', TextType::class, ['label' => 'Ulice'])
                ->add('city', TextType::class, ['label' => 'Město'])
                ->add('postcode', TextType::class, ['label' => 'PSČ'])
                ->add('country', TextType::class, ['label' => 'Stát'])
                ->add('ic', TextType::class, ['label' => 'IČ'])
                ->add('dic', TextType::class, ['label' => 'DIČ'])
                ->add('email', EmailType::class, ['label' => 'E-mail']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}