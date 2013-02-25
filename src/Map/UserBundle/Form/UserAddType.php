<?php

namespace Map\UserBundle\Form;

use Map\CoreBundle\Util\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\Email;

class UserAddType extends DefaultType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('validation_constraint' => array(
                new MinLength(2), new MaxLength(50)))
            )
            ->add('name', null, array('validation_constraint' => array(
                new MinLength(2), new MaxLength(50)))
            )
            ->add('displayname', null, array('validation_constraint' => array(
                new MinLength(2), new MaxLength(50)))
            )
            ->add('username', null, array('validation_constraint' => array(
                new MinLength(2), new MaxLength(50)))
            )
            ->add('plainPassword', 'password', array('label' => 'Password'))
            ->add('email', null, array('validation_constraint' => array(
                new Email(array('message' => 'Invalid email address'))))
            )
            ->add('superAdmin', 'checkbox', array('required' => false))
            ->add(
                'details', 'textarea', array(
                    'required' => false,
                    'attr'  => array(
                        'class' => 'input-xxlarge',
                        'rows'  => 4
                    )
                )
            )
            ->add('locked', 'checkbox', array('required' => false));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Map\UserBundle\Entity\User'
        ));
    }
    public function getName()
    {
        return "map_userbundle_usertype";
    }
}