<?php
/**
 * Resource form handler class.
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
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 *
 */

namespace Map\DomainBundle\Form;

use Map\CoreBundle\Util\Form\FormHandler;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Map\DomainBundle\Entity\Domain;

class ResourceFormHandler extends FormHandler
{
    protected $_domain;

    public function __construct(
        Form $form, Request $request, EntityManager $em, Domain $dm
    )
    {
        parent::__construct($form, $request, $em);
        $this->_domain = $dm;
    }
    
    public function process()
    {
        if ($this->_request->getMethod() == 'POST') {
            
            $this->_form->bindRequest($this->_request);
            
            if ($this->_form->isValid()) {
                
                $entity = $this->_form->getData();
                $entity->setDomain($this->_domain);
            
                $this->onSuccess($entity);
                
                return true;
            }            
        }
        return false;
    }
}
