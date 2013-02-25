<?php

namespace Map\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map\UserBundle\Entity\User;
use Map\UserBundle\Form\UserAddType;
use Map\UserBundle\Form\UserEditType;
use Map\UserBundle\Form\UserFormHandler;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        
        $users = $userManager->findUsers();
        
        return $this->render(
            'MapUserBundle:User:index.html.twig',
            array('users' => $users)
        );
    }

    public function addAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $user        = $userManager->createUser();
        $form        = $this->createForm(new UserAddType(), $user);
        
        $user->setEnabled(true);
        
        $handler = new UserFormHandler(
            $form,
            $this->getRequest(),
            $userManager
        );
        
        if ($handler->process()) {
            
            $id = $user->getId();
            
            $this->get('session')->getFlashBag()
                ->add('success', 'User added successfully !');
                        
            return $this->redirect(
                $this->generateUrl('user_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapUserBundle:User:add.html.twig',
            array('form' => $form->createView())
        );
    }

    public function viewAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        
        if ( ! $user = $userManager->findUserBy(array('id' => $id))) {
            throw $this->createNotFoundException('User[id='.$id.'] not found');
        }
        return $this->render(
            'MapUserBundle:User:view.html.twig',
            array('user' => $user)
        );
    }
    
    public function editAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        
        if ( ! $user = $userManager->findUserBy(array('id' => $id))) {
            throw $this->createNotFoundException('User[id='.$id.'] not found');
        }
        $form        = $this->createForm(new UserEditType(), $user);
        
        $handler = new UserFormHandler(
            $form,
            $this->getRequest(),
            $userManager
        );
             
        if ($handler->process()) {
            
            $this->get('session')->getFlashBag()
                ->add('success', 'User edited successfully !');
            
            return $this->redirect(
                $this->generateUrl('user_view', array('id' => $id))
            );
        }
        return $this->render(
            'MapUserBundle:User:edit.html.twig',
            array('form' => $form->createView(), 'user' => $user)
        );
    }
    
    public function delAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        
        if ( ! $user = $userManager->findUserBy(array('id' => $id))) {
            throw $this->createNotFoundException('User[id='.$id.'] not found');
        }
        
        if( $this->get('request')->getMethod() == 'POST' ) {
                       
            $userManager->deleteUser($user);
            
            $this->get('session')->getFlashBag()
                ->add('success', 'User removed successfully !');
                        
            return $this->redirect($this->generateUrl('user_index'));
        }
        return $this->render(
            'MapUserBundle:User:del.html.twig',
            array('user' => $user)
        );
    }
}