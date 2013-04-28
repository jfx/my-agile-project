<?php
/**
 * Menu select form class.
 *
 * LICENSE : This file is part of My Agile Project.
 *
 * My Agile Project is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * My Agile Project is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface;

class MenuSelectType extends AbstractType implements NavbarFormInterface
{
    protected $_user;
    
    public function __construct(ContainerInterface $container)
    {
        $this->_user = $container->get('security.context')->getToken()->getUser();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentDomain = $this->_user->getCurrentDomain();
        if (is_null($currentDomain)) {
            $currentDomainId = 0;
        } else {
            $currentDomainId = $currentDomain->getId();
        }
        $availableDomains = $this->_user->getAvailableDomains();
        
        if (key_exists($currentDomainId, $availableDomains)) {
            $builder
                ->add('search', 'choice', array(
                    'choices' => $availableDomains,
                    'data' => $currentDomainId,
                    'widget_control_group' => false,
                    'widget_controls' => false,
                    'attr' => array(
                        'class' => "span2",
                        'onChange' => "this.form.submit()"
                    )
                ))
            ;        
        } else {
            $builder
                ->add('search', 'choice', array(
                    'choices' => $availableDomains,
                    'empty_value' => '',
                    'widget_control_group' => false,
                    'widget_controls' => false,
                    'attr' => array(
                        'class' => "span2",
                        'onChange' => "this.form.submit()"
                    )
                ))
            ;          
        }                
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
        return "domain_select"; # return here the name of the route the form should point to
    }
}