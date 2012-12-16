<?php

namespace Map\AdminBundle\Form;

use Map\CoreBundle\Util\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;

class ApplicationType extends DefaultType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', null, array('validation_constraint' => array(
                new MinLength(2), new MaxLength(50)))
            )
            ->add(
                'Details', 'textarea', array(
                    'required' => false,
                    'attr'  => array(
                        'class' => 'input-xxlarge',
                        'rows'  => 4
                    )
                )
            );
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Map\AdminBundle\Entity\Application'
        ));
    }
    public function getName()
    {
        return "map_adminbundle_applicationtype";
    }
}