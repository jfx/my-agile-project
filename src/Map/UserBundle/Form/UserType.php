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

namespace Map\UserBundle\Form;

use Map\CoreBundle\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * User edit form class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UserType extends DefaultType
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
        $builder
            ->add(
                'firstname',
                'text',
                array()
            )
            ->add(
                'name',
                'text',
                array()
            )
            ->add(
                'displayname',
                'text',
                array()
            )
            ->add(
                'username',
                'text',
                array(
                    'constraints' => array(
                        new Length(array('min' => 2, 'max' => 50))
                    )
                )
            )
            ->add(
                'updatedPassword',
                'password',
                array(
                    'label' => 'Password',
                    'required' => false
                )
            )
            ->add(
                'email',
                'text',
                array(
                    'constraints' => array(
                        new Email(array('message' => 'Invalid email address'))
                    )
                )
            )
            ->add(
                'superAdmin',
                'checkbox',
                array(
                    'label' => 'Super-admin',
                    'required' => false
                )
            )
            ->add(
                'details',
                'textarea',
                array(
                    'required' => false,
                    'attr'  => array(
                        'rows'  => 4
                    )
                )
            )
            ->add(
                'locked',
                'checkbox',
                array(
                    'required' => false
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
            $this->setDisabledAttr(
                array('data_class' => 'Map\UserBundle\Entity\User')
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "map_user";
    }
}
