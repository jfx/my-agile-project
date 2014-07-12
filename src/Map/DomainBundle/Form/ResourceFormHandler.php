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

namespace Map\DomainBundle\Form;

use Map\CoreBundle\Form\FormHandler;
use Map\DomainBundle\Entity\Domain;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resource form handler class.
 *
 * @category  MyAgileProject
 * @package   Domain
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2013 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class ResourceFormHandler extends FormHandler
{
    /**
     * @var Domain Domain
     */
    protected $domain;

    /**
     * Constructor
     *
     * @param Form               $form      Form.
     * @param Request            $request   Http request.
     * @param ContainerInterface $container Container
     * @param Domain             $dm        The domain.
     */
    public function __construct(
        Form $form,
        Request $request,
        ContainerInterface $container,
        Domain $dm
    ) {
        parent::__construct($form, $request, $container);
        $this->domain = $dm;
    }

    /**
     * For a submited form, valid it and update database.
     *
     * @return bolean
     */
    public function process()
    {
        if ($this->request->getMethod() == 'POST') {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $entity = $this->form->getData();
                $entity->setDomain($this->domain);

                $this->onSuccess($entity);

                return true;
            } else {
                $this->session->getFlashBag()->add(
                    'danger',
                    'Integrity constraint violation !'
                );
            }
        }

        return false;
    }
}
