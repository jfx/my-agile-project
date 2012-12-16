<?php

namespace Map\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    protected $securityContext;
    protected $isLoggedIn;
    
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
        parent::__construct($factory);
    
        $this->securityContext = $securityContext;
        // $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
    }
    
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
    
        $menu->addChild('Home', array('route' => 'adminApplication_add'));
        
        $this->addDivider($menu, true);
                
        $dropdownAdmin = $this->createDropdownMenuItem(
            $menu, "Admin", false, array('icon' => 'caret')
        );
        $dropdownAdmin->addChild('Preferences', array('route' => 'adminApplication_add'));
        $dropdownAdmin->addChild('Applications', array('route' => 'adminApplication_index'));
        
        $this->addDivider($menu, true);
    
        return $menu;
    }
    
    public function createRightSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
    
        $menu->addChild('Log out', array('route' => 'adminApplication_add'));
    
        return $menu;
    }
}
