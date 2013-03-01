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