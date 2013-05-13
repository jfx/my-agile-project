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
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Update domain service class.
 *
 * @category  MyAgileProject
 * @package   User
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class UpdateDomain4User
{
    /**
     * @var Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var FOS\UserBundle\Model\UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param SecurityContextInterface $securityContext The security context.
     * @param EntityManager            $entityManager   The doctrine entity manager.
     * @param UserManagerInterface     $userManager     The user manager.
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        EntityManager $entityManager,
        UserManagerInterface $userManager
    ) {
        $this->securityContext = $securityContext;
        $this->entityManager   = $entityManager;
        $this->userManager     = $userManager;
    }

    /**
     * Set the current domain for a user and set role.
     *
     * @param Domain|null $domain The domain, if null unset current domain.
     * @param int|null    $userId The user id, if null get user id from context.
     *
     * @return void
     */
    public function setCurrentDomain($domain, $userId = null)
    {
        if ($userId == null) {
            
            $user = $this->securityContext->getToken()->getUser();
        } else {
            if (! $user = $this->userManager->findUserBy(array('id' => $userId))) {
                throw $this->createNotFoundException(
                    'User[id='.$userId.'] not found'
                );
            }
        }
        $user->unsetDomainRole();

        if ($domain == null) {
            $user->unsetCurrentDomain();
        } else {
            $user->setCurrentDomain($domain);

            $repository = $this->entityManager->getRepository(
                'MapUserBundle:UserDmRole'
            );

            try {
                $userDmRole = $repository->findByUserIdDomainId(
                    $user->getId(),
                    $domain->getId()
                );
                $user->addRole($userDmRole->getRole()->getId());
                $user->setCurrentRoleLabel($userDmRole->getRole()->getLabel());
            } catch (Exception $e) {
            }
        }
        $this->userManager->updateUser($user);
    }

    /**
     * Refresh available domains list.
     *
     * @param int $userId The user id.
     *
     * @return void
     */
    public function refreshAvailableDomains4UserId($userId)
    {
        if (! $user = $this->userManager->findUserBy(array('id' => $userId))) {
            throw $this->createNotFoundException(
                'User[id='.$userId.'] not found'
            );
        }
        $repository = $this->entityManager->getRepository(
            'MapUserBundle:UserDmRole'
        );

        $availableDomains = $repository->findAvailableDomainsByUser($user);

        $arrayDomains = array();

        foreach ($availableDomains as $domain) {
            $arrayDomains[$domain['id']] = $domain['name'];
        }

        $user->setAvailableDomains($arrayDomains);
        $this->userManager->updateUser($user);
    }
}
