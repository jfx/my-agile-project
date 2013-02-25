<?php

namespace Map\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    protected $securityContext;
    
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
        parent::__construct($factory);
    
        $this->securityContext = $securityContext;
    }
    
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
    
        $menu->addChild('Home', array('route' => 'home_index'));
        
        $this->addDivider($menu, true);
                
        $dropdownAdmin = $this->createDropdownMenuItem(
            $menu, "Admin", false, array('icon' => 'caret')
        );
        $dropdownAdmin->addChild('Password', array('route' => 'fos_user_change_password'));

        $this->addDivider($dropdownAdmin);
        
        $dropdownAdmin->addChild('Users', array('route' => 'user_index'));
        $dropdownAdmin->addChild('Applications', array('route' => 'adminApplication_index'));
        
        $this->addDivider($menu, true);
    
        return $menu;
    }
    
    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        
        $user = $this->securityContext->getToken()->getUser();
        $username = ucfirst($user->getUsername());
        
        $menu->addChild($username.' (user++)', array('route' => 'fos_user_profile_show'));
        
        $this->addDivider($menu, true);
    
        $menu->addChild('Log out', array('route' => 'fos_user_security_logout'));
    
        return $menu;
    }
}
