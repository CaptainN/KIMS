<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 */
$this->registerCss(''
 . '.main-menu {text-align: center;}'
 . '.main-menu .btn {width: 250px; font-size: 36px; margin: 4px;}', ['\app\assets\AppAsset']
);
?>
<div class="site-index">
   <div class="body-content">
      <div class="row">
         <div class="main-menu">
            <?php
            if (Yii::$app->user->isSuperAdmin)
            {
               ?>
               <div><?= Html::a('Users', ['auth/user'], ['class' => 'btn btn-default']) ?></div>
               <?php
            }
            ?>
            <?php
            if (Yii::$app->user->can('changeSchool'))
            {
               ?>
               <div><?= Html::a('Classes', ['class/index'], ['class' => 'btn btn-default']) ?></div>
               <?php
            }
            ?>
            <div><?= Html::a('Students', ['student/index'], ['class' => 'btn btn-default']) ?></div>
         </div>
      </div>

   </div>
</div>
