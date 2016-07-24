<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'data' => 2,
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                
                $treeChoices = [
                    1 => [10 => 10, 11 => 11],
                    2 => [20 => 20, 21 => 21],
                ];
                
                /* @var $field1 \Symfony\Component\Form\Form */
                $field1 = $form->get('field1');
                $value1 = $field1->getData() ?: 1;
                
                $choices = $treeChoices[$value1];

                $form->add('field2', ChoiceType::class, [
                    'choices' => $choices,
                ]);
            }
        );
    }
}
