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

use Map\CoreBundle\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Map\DomainBundle\Entity\Domain;
use Map\UserBundle\Entity\UserRepository;
use Map\UserBundle\Entity\RoleRepository;

/**
 * Resource form class for add action.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */
class ResourceAddType extends DefaultType
{
    /**
     * @var Domain $domain
     */
    protected $domain;

    /**
     * Constructor.
     *
     * @param Domain $domain The domain in which the resource will be added.
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

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

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'Map\UserBundle\Entity\UserDmRole')
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "map_domainbundle_resourceaddtype";
    }
}
