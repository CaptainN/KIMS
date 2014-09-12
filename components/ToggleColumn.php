<?php

namespace app\components;

//use Yii;
//use yii\base\InvalidConfigException;
//use yii\base\Model;
//use yii\grid\DataColumn;
//use yii\helpers\ArrayHelper;
//use yii\helpers\Html;
//use yii\helpers\Url;

class ToggleColumn extends \dosamigos\grid\ToggleColumn
{

   /**
    * @inheritdoc
    */
   public $onIcon = 'glyphicon glyphicon-check';

   /**
    * @* @inheritdoc
    */
   public $offIcon = 'glyphicon glyphicon-unchecked';

}
