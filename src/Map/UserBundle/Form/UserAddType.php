<?php
/**
 * User add form class.
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
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\UserBundle\Form;

use Map\CoreBundle\Util\Form\DefaultType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

class UserAddType extends DefaultType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('validation_constraint' => array(
                new Length(array('min' => 2, 'max' => 50))
            )))
            ->add('name', null, array('validation_constraint' => array(
                new Length(array('min' => 2, 'max' => 50))
            )))
            ->add('displayname', null, array('validation_constraint' => array(
                new Length(array('min' => 2, 'max' => 50))
            )))
            ->add('username', null, array('validation_constraint' => array(
                new Length(array('min' => 2, 'max' => 50))
            )))
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