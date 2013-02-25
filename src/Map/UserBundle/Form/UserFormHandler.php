<?php
/**
 * Form handler class.
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

use Map\CoreBundle\Util\Form\FormHandler;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class UserFormHandler extends FormHandler
{
    protected $_form;
    protected $_request;
    protected $_em;

    public function __construct(Form $form, Request $request, UserManager $um)
    {
        $this->_form = $form;
        $this->_request = $request;
        $this->_em = $um;
    }

    public function onSuccess($entity)
    {
        $this->_em->updateUser($entity);
    }
}
