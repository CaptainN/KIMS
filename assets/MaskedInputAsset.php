<?php

namespace app\assets;

/**
 * Includes jQuery Masked Input, requires jQuery
 *
 * @author Dan
 */
class MaskedInputAsset extends AppAsset
{
   public $css = [
   ];
   public $js = [
     'js/jquery.maskedinput.min.js',
   ];
   public $depends = [
     'app\assets\AppAsset',
   ];
}
