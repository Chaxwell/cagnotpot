<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $campaign = $event->getData();
            $form = $event->getForm();

            if (!$campaign || $campaign->getId() === null) {
                $form
                    ->add('title')
                    ->add('goal')
                    ->add('author')
                    ->add('email');
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
