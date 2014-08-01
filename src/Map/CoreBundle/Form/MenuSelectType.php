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
use Map\UserBundle\Entity\User;
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
class MenuSelectType extends DefaultType
{
    /**
     * @var User User object
     */
    protected $user;

    /**
     * Constructor
     *
     * @param User $user The user.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

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

        $currentProject = $this->user->getCurrentProject();
        if ($currentProject === null) {
            $currentProjectId = 0;
        } else {
            $currentProjectId = $currentProject->getId();
        }
        $availableProjects = $this->user->getAvailableProjects();

        if (count($availableProjects) > 0) {

            $keyExists = false;
            foreach ($availableProjects as $projects4aDomain) {
                if (array_key_exists($currentProjectId, $projects4aDomain)) {
                    $keyExists = true;
                }
            }
            if ($keyExists) {
                $builder->add(
                    'search',
                    'choice',
                    array(
                        'label' => false,
                        'choices' => $availableProjects,
                        'data' => $currentProjectId,
                        'horizontal_input_wrapper_class' => 'col-lg-12',
                        'attr' => array(
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
                        'choices' => $availableProjects,
                        'empty_value' => '',
                        'horizontal_input_wrapper_class' => 'col-lg-12',
                        'attr' => array(
                            'onChange' => "this.form.submit()"
                        )
                    )
                );
            }
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
        return "map_menu_select";
    }
}
