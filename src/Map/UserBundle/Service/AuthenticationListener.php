<?php
/**
 * Authentication listener class.
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

namespace Map\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class AuthenticationListener
{
    protected $_entityManager;
    protected $_userManager;
    
    public function __construct(
        EntityManager $entityManager,
        UserManagerInterface $userManager
    )
    {
        $this->_entityManager   = $entityManager;
        $this->_userManager     = $userManager;
    }
    
    public function onSecurityAuthenticationSuccess(AuthenticationEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $user = $token->getUser();
        
        $repository = $this->_entityManager->getRepository(
            'MapUserBundle:UserDmRole'
        );
        // Update current domain role
        $currentDomain = $user->getCurrentDomain();
        
        $user->unsetDomainRole();
        
        if ($currentDomain != null) {
            try {
                $userDmRole = $repository->findByUserIdDomainId(
                    $user->getId(), $currentDomain->getId()
                );
                $user->addRole($userDmRole->getRole()->getId());
                $user->setCurrentRoleLabel($userDmRole->getRole()->getLabel());
            }
            catch (\Exception $e) { }
        }
        
        // Update available domains
        $availableDomains = $repository->findAvailableDomainsByUser($user);

        $arrayDomains = array();
        
        foreach ($availableDomains as $domain) {
            $arrayDomains[$domain['id']] = $domain['name'];
        }

        $user->setAvailableDomains($arrayDomains);
        $this->_userManager->updateUser($user);
        
        $token->setAuthenticated(false);
    }
}