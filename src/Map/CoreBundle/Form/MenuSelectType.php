<?php
/**
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
 */

namespace Map\CoreBundle\Form;

use Map\CoreBundle\Form\DefaultType;
use Mopa\Bundle\BootstrapBundle\Navbar\NavbarFormInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Menu select form class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class MenuSelectType extends DefaultType implements
    NavbarFormInterface,
    ContainerAwareInterface
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface Container
     */
    protected $container;

    /**
     * {@inheritDoc}
     *
     * @param FormBuilderInterface $builder Form builder.
     * @param array                $options Array of options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $currentDomain = $user->getCurrentDomain();
        if ($currentDomain === null) {
            $currentDomainId = 0;
        } else {
            $currentDomainId = $currentDomain->getId();
        }
        $availableDomains = $user->getAvailableDomains();

        if (key_exists($currentDomainId, $availableDomains)) {
            $builder->add(
                'search',
                'choice',
                array(
                    'label' => false,
                    'choices' => $availableDomains,
                    'data' => $currentDomainId,
                    'widget_control_group' => false,
                    'widget_controls' => false,
                    'attr' => array(
                        'class' => "span2",
                        'onChange' => "this.form.submit()"
                    )
                )
            );
        } else {
            $builder->add(
                'search',
                'choice',
                array(
                    'label' => false,
                    'choices' => $availableDomains,
                    'empty_value' => '',
                    'widget_control_group' => false,
                    'widget_controls' => false,
                    'attr' => array(
                        'class' => "span2",
                        'onChange' => "this.form.submit()"
                    )
                )
            );
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return string Name of form.
     */
    public function getName()
    {
        return 'map_menu_select';
    }

    /**
     * {@inheritDoc}
     *
     * @return string route name.
     */
    public function getRoute()
    {
        return "domain_select";
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance
     * or null
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
