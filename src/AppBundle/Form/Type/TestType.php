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
                $form->add('field3', ChoiceType::class, [
                    'choices' => [],
                    'required' => false,
                    'placeholder' => 'choice 3',
                ]);
            }
        );
        
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                
                $form = $event->getForm();
                $data = $event->getData();
                
                /* changed field1 */
                $value1 = isset($data['field1']) ? $data['field1'] : null;
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
                
                /* changed field2 */
                $value2 = isset($data['field2']) ? $data['field2'] : null;
                $treeChoices = [
                    10 => [100 => 100, 101 => 101],
                    11 => [110 => 110, 111 => 111],
                    20 => [200 => 200, 201 => 201],
                    21 => [210 => 210, 211 => 211],
                ];
                $choices = $value2 ? $treeChoices[$value2] : [];
                $form->add('field3', ChoiceType::class, [
                    'choices' => $choices,
                    'required' => false,
                    'placeholder' => 'choice 3',
                ]);
            }
        );
    }
}
