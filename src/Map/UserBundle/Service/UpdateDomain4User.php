<?php
/**
 * Update domain service class.
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

use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;

class UpdateDomain4User
{
    protected $_securityContext;
    protected $_entityManager;
    protected $_userManager;
    
    public function __construct(
        SecurityContextInterface $securityContext,
        EntityManager $entityManager,
        UserManagerInterface $userManager
    )
    {
        $this->_securityContext = $securityContext;
        $this->_entityManager   = $entityManager;
        $this->_userManager     = $userManager;
    }
    
    public function setCurrentDomain($domain, $userId = null)
    {
        if ($userId == null) {
            $getUserFromContext = TRUE;
            $user = $this->_securityContext->getToken()->getUser();
        }
        else {
            $getUserFromContext = FALSE;
            if ( ! $user = $this->_userManager->findUserBy(array('id' => $userId))) {
                throw $this->createNotFoundException(
                    'User[id='.$userId.'] not found'
                );
            }
        }      
        $user->unsetDomainRole();

        if ($domain == null) {
            $user->unsetCurrentDomain();
        }
        else {
            $user->setCurrentDomain($domain);

            $repository = $this->_entityManager->getRepository(
                'MapUserBundle:UserDmRole'
            );

            try {
                $userDmRole = $repository->findByUserIdDomainId(
                    $user->getId(), $domain->getId()
                );
                $user->addRole($userDmRole->getRole()->getId());
                $user->setCurrentRoleLabel($userDmRole->getRole()->getLabel());
            }
            catch (\Exception $e) { }
        }
        $this->_userManager->updateUser($user);
        
        // Update role in cache
        if($getUserFromContext) {
            $this->_securityContext->getToken()->setAuthenticated(false);
        }
    }
    
    public function refreshAvailableDomains4UserId($userId)
    {
        if ( ! $user = $this->_userManager->findUserBy(array('id' => $userId))) {
            throw $this->createNotFoundException(
                'User[id='.$userId.'] not found'
            );
        }
        $repository = $this->_entityManager->getRepository(
            'MapUserBundle:UserDmRole'
        );
        
        $availableDomains = $repository->findAvailableDomainsByUser($user);

        $arrayDomains = array();
        
        foreach ($availableDomains as $domain) {
            $arrayDomains[$domain['id']] = $domain['name'];
        }

        $user->setAvailableDomains($arrayDomains);
        $this->_userManager->updateUser($user);
    }
}