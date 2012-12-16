<?php
namespace Map\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface;

class MenuSelectType extends AbstractType implements NavbarFormInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', 'choice', array(
                'choices' => array(
                    1 => 'Appli 1',
                    2 => 'Appli 2',
                    3 => 'Appli 3'
                ),
                'data' => 2,
                'widget_control_group' => false,
                'widget_controls' => false,
                'attr' => array(
                    'class' => "span2",
                    'onChange' => "this.form.submit()"
                )
            ))
        ;
    }
    public function getName()
    {
        return 'map_menu_select';
    }
    /**
* To implement NavbarFormTypeInterface
*/
    public function getRoute()
    {
        return "adminApplication_index"; # return here the name of the route the form should point to
    }
}