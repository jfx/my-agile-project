<?php

namespace Map\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MapUserBundle extends Bundle
{
    public function getParent()
    {       
        return 'FOSUserBundle';
    }
}
