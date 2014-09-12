<?php

namespace app\widgets;

/**
 * Description of ActiveField
 *
 * @author Dan
 */
class ActiveField extends \kartik\widgets\ActiveField
{
   /*
    * @inheritdoc
    */
   protected function initPlaceholder(&$options)
   {
      if ($this->autoPlaceholder)
      {
         $attr = preg_replace('/^\[[^\]]\]/', '', $this->attribute);
         $label = Html::encode($this->model->getAttributeLabel($attr));
         $this->inputOptions['placeholder'] = $label;
         $options['placeholder'] = $label;
      }
   }
}
