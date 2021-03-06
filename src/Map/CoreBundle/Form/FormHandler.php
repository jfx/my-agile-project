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

namespace Map\CoreBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Validator;

/**
 * Form handler class.
 *
 * @category  MyAgileProject
 * @package   Core
 * @author    Francois-Xavier Soubirou <soubirou@yahoo.fr>
 * @copyright 2012 Francois-Xavier Soubirou
 * @license   http://www.gnu.org/licenses/   GPLv3
 * @link      http://www.myagileproject.org
 * @since     2
 */
class FormHandler
{
    /**
     * @var Form Form
     */
    protected $form;

    /**
     * @var Request Request
     */
    protected $request;

    /**
     * @var EntityManager Entity manager
     */
    protected $em;

    /**
     * @var Validator Validator
     *
     */
    protected $validator;

    /**
     * @var Session Session
     *
     */
    protected $session;

    /**
     * Constructor
     *
     * @param Form               $form      Form.
     * @param Request            $request   Http request.
     * @param ContainerInterface $container Container.
     */
    public function __construct(
        Form $form,
        Request $request,
        ContainerInterface $container
    ) {
        $this->form      = $form;
        $this->request   = $request;
        $this->em        = $container->get('doctrine')->getManager();
        $this->validator = $container->get('validator');
        $this->session   = $container->get('session');
    }

    /**
     * For a submited form, valid it and update database.
     *
     * @return boolean
     */
    public function process()
    {
        if ($this->request->getMethod() == 'POST') {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $this->onSuccess($this->form->getData());

                return true;
            } else {
                $errors = $this->validator->validate($this->form->getData());

                foreach ($errors as $error) {

                    $this->session->getFlashBag()->add(
                        'danger',
                        ucfirst($error->getPropertyPath())
                        .' : '.$error->getMessage()
                    );
                }
            }
        }

        return false;
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
        $this->em->persist($entity);
        $this->em->flush();
    }
}
