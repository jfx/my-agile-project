<?php

namespace Map\UserBundle\Form;

use Map\CoreBundle\Util\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;

class UserPasswordType extends DefaultType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current_password', 'password', array(
                'label' => 'Current password',
                'mapped' => false,
                'constraints' => new UserPassword(),
                'invalid_message' => 'This value should be the user current password',
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options' => array('label' => 'New password'),
                'second_options' => array('label' => 'Verification'),
                'invalid_message' => 'The entered passwords don\'t match',
            ));
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