<?php

namespace Map\CoreBundle\Util\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

abstract class DefaultType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
      $view->set('render_fieldset', false);
      $view->set('show_legend', false);   
    }
}