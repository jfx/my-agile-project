<?php
/**
 * Resource form class.
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
 */

namespace Map\DomainBundle\Form;

use Map\UserBundle\Entity\RoleRepository;
use Map\UserBundle\Entity\UserRepository;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Resource form class for add action.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2014 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
class ResourceTypeAdd extends ResourceType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $domain = $this->domain;
     
        $builder
            ->add(
                'user',
                'entity',
                array(
                    'label' => 'Resource',
                    'class' => 'Map\UserBundle\Entity\User',
                    'property' => 'nameFirstname',
                    'query_builder' =>
                        function (UserRepository $er) use ($domain) {
                            return $er->getQBAvailableUserByDomain($domain);
                    }
                )
            )
            ->add(
                'role',
                'entity',
                array(
                    'label' => 'Role',
                    'class' => 'Map\UserBundle\Entity\Role',
                    'property' => 'label',
                    'query_builder' => function (RoleRepository $er) {
                        return $er->getQBAllOrdered();
                    },
                )
            );
    }
}
