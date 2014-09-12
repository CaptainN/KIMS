<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\web\JsExpression;
use app\assets\AppAsset;
use dosamigos\editable\Editable;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
$this->registerJsFile('js/layout-main.js', ['\app\assets\AppAsset']);
$this->registerCssFile('css/layout-main.css', ['\app\assets\AppAsset']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
   <head>
      <meta charset="<?= Yii::$app->charset ?>"/>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?= Html::encode($this->title) ?></title>
      <?php $this->head() ?>
   </head>
   <body>

      <?php $this->beginBody() ?>
      <div class="wrap">
         <?php
         NavBar::begin([
            'brandLabel' => 'KIMS',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
               'class' => 'navbar-inverse navbar-fixed-top',
            ],
         ]);

         // show school switcher
         if (Yii::$app->user->can('changeSchool'))
         {
            echo Editable::widget([
               'model' => Yii::$app->user->identity,
               'attribute' => 'schoolId',
               'value' => 'school.name',
               'url' => 'user/editable',
               'type' => 'select',
               'mode' => 'inline',
               'options' => [
                  'class' => 'navbar-brand',
               ],
               'clientOptions' => [
                  'showbuttons' => false,
                  'value' => Yii::$app->user->identity->schoolId,
                  'source' => Url::to(['school/select']),
                  'success' => new JsExpression('function(a){'
                   . '$("<div>").addClass("alert alert-info").html("Switching schools...").appendTo("#alerts");'
                   . 'location.reload(true);'
                   . '}'),
               ]
            ]);
         }
         // show only current school name for non-superadmins
         else if (!Yii::$app->user->isGuest)
         {
            echo '<a href="/" class="navbar-brand">'
            . Yii::$app->user->identity->school->name . '</a>';
         }

         echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
               ['label' => 'Home', 'url' => ['/site/index']],
               //['label' => 'About', 'url' => ['/site/about']],
               ['label' => 'Contact', 'url' => ['/site/contact']],
               Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/auth/default/login']] :
                ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                  'url' => ['/auth/default/logout'],
                  'linkOptions' => ['data-method' => 'post']],
               '<li><a href="' . Url::to(['/user/config']) . '" title="Profile">'
               . '<span class="glyphicon glyphicon-user"></span></a></li>',
            ],
         ]);
         NavBar::end();
         ?>

         <div class="container">
            <?=
            Breadcrumbs::widget([
               'links' => isset($this->params['breadcrumbs']) ?
                $this->params['breadcrumbs'] : [],
            ])
            ?>
            <div id="alerts"><?= alerts() ?></div>
            <?= $content ?>
         </div>
      </div>

      <footer class="footer">
         <div class="container">
            <p class="pull-left">&copy; New Paltz Karate Academy <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
         </div>
      </footer>

      <?php $this->endBody() ?>
   </body>
</html>
<?php $this->endPage() ?>
