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

namespace Map\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

/**
 * Authentication listener class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class AuthenticationListener
{
    /**
     * @var Doctrine\ORM\EntityManager Entity manager
     */
    protected $entityManager;

    /**
     * @var FOS\UserBundle\Model\UserManagerInterface User manager
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param EntityManager        $entityManager The doctrine entity manager.
     * @param UserManagerInterface $userManager   The user manager.
     */
    public function __construct(
        EntityManager $entityManager,
        UserManagerInterface $userManager
    ) {
        $this->entityManager = $entityManager;
        $this->userManager   = $userManager;
    }

    /**
     * When authentication succeed (login or cookie remember), refresh role for
     * the current domain and refresh list of available domains (select box).
     *
     * @param AuthenticationEvent $event The event object.
     *
     * @return void
     */
    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $user = $token->getUser();

        $repository = $this->entityManager->getRepository(
            'MapUserBundle:UserDmRole'
        );
        // Update current domain role
        $currentDomain = $user->getCurrentDomain();

        $user->unsetDomainRole();

        if ($currentDomain !== null) {
            try {
                $userDmRole = $repository->findByUserIdDomainId(
                    $user->getId(),
                    $currentDomain->getId()
                );
                $user->addRole($userDmRole->getRole()->getId());
                $user->setCurrentRoleLabel($userDmRole->getRole()->getLabel());
            } catch (Exception $e) {
            }
        }

        // Update available domains
        $availableDomains = $repository->findAvailableDomainsByUser($user);

        $arrayDomains = array();

        foreach ($availableDomains as $domain) {
            $arrayDomains[$domain['id']] = $domain['name'];
        }

        $user->setAvailableDomains($arrayDomains);
        $this->userManager->updateUser($user);
    }
}
