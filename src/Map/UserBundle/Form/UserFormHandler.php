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

use FOS\UserBundle\Model\UserManager;
use Map\CoreBundle\Form\FormHandler;
use Map\UserBundle\Service\PasswordFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Form handler class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UserFormHandler extends FormHandler
{
    /**
     * @var PasswordFactory Password factory
     */
    protected $passwordFactory;

    /**
     * @var UserManager User manager
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param Form               $form      Form.
     * @param Request            $request   Http request.
     * @param ContainerInterface $container Container.
     * @param UserManager        $um        User manager.
     */
    public function __construct(
        Form $form,
        Request $request,
        ContainerInterface $container,
        UserManager $um
    ) {
        parent::__construct($form, $request, $container);
        $this->passwordFactory = $container->get('map_user.passwordFactory');
        $this->userManager = $um;
    }

    /**
     * Save entity in database.
     *
     * @param mixed $entity Object entity.
     *
     * @return void
     */
    public function onSuccess($entity)
    {
        // If add user without password, then set a default password.
        $route = $this->request->get('_route');

        if (($route == 'user_add') && ($entity->getPlainPassword() === null)) {

            $password = $this->passwordFactory->generatePassword();
            $entity->setPlainPassword($password);
        }
        $this->userManager->updateUser($entity);
    }
}
