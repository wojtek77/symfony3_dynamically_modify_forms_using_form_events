<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * @author Wojciech Brüggemann <wojtek77@o2.pl>
 */
class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field1', ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                ],
                'required' => false,
                'placeholder' => 'choice 1',
            ])
        ;
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $form->add('field2', ChoiceType::class, [
                    'choices' => [],
                    'required' => false,
                    'placeholder' => 'choice 2',
                ]);
            }
        );
        
        $builder->get('field1')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm()->getParent();
                $value1 = $event->getForm()->getData();
                $treeChoices = [
                    1 => [10 => 10, 11 => 11],
                    2 => [20 => 20, 21 => 21],
                ];
                $choices = $value1 ? $treeChoices[$value1] : [];
                $form->add('field2', ChoiceType::class, [
                    'choices' => $choices,
                    'required' => false,
                    'placeholder' => 'choice 2',
                ]);
            }
        );
    }
}
