<?php

function app()
{
   return \Yii::$app;
}

/**
 * @return \app\components\User
 */
function user()
{
   return \Yii::$app->user;
}

/*
 * Shortcut to Yii::$app->request->post()
 * @return array
 */
function post($name = null)
{
   return \Yii::$app->request->post($name);
}

/*
 * Shortcut to Yii::$app->request->get()
 * @return array
 */
function get($name = null)
{
   return \Yii::$app->request->get($name);
}

/*
 * Shortcut to Yii::$app->request->queryParams
 * @return array
 */
function queryParams()
{
   return \Yii::$app->request->getQueryParams();
}

/**
 * Sets a flash success message in the session
 * @param type $msg
 */
function setSuccess($msg)
{
   Yii::$app->session->setFlash('success', $msg);
}

/**
 * Sets a flash error messge in the session
 * @param type $msg
 */
function setError($msg)
{
   Yii::$app->session->setFlash('error', $msg);
}

/**
 * Sets a flash info messge in the session
 * @param type $msg
 */
function setInfo($msg)
{
   Yii::$app->session->setFlash('info', $msg);
}

/**
 * Sets a flash warning messge in the session
 * @param type $msg
 */
function setWarning($msg)
{
   Yii::$app->session->setFlash('warning', $msg);
}

/**
 * Echo any error, warning, info or success flashes, then remove them.
 */
function alerts()
{
   $alerts = [];
   $classes = [
      'error' => 'danger',
      'warning' => 'warning',
      'info' => 'info',
      'success' => 'success',
   ];
   foreach (['error', 'warning', 'info', 'success'] as $alert)
   {
      $body = Yii::$app->session->getFlash($alert);
      if (isset($body))
      {
         $alerts[] = yii\bootstrap\Alert::widget([
            'body' => $body,
            'options' => ['class' => 'alert-' . $classes[$alert]],
         ]);
         Yii::$app->session->removeFlash($alert);
      }
   }
   return join('', $alerts);
}

/**
 * Removes and returnes the value of the given index.
 * @param type $array
 * @param type $index
 */
function array_remove(&$array, $index)
{
   $val = $array[$index];
   unset($array[$index]);
   return $val;
}

/**
 * Overloaded version of Html::a(), adds icon option
 */
function a($text, $url, $options)
{
   $icon = array_remove($options, 'icon');
   $prefix = "<span class='glyphicon glyphicon-{$icon}'></span> ";
   return \yii\helpers\Html::a($prefix . $text, $url, $options);
}

/**
 * Overloaded version of Html::submitButton(), adds icon option
 */
function submitButton($text, $options)
{
   $icon = array_remove($options, 'icon');
   $prefix = "<span class='glyphicon glyphicon-{$icon}'></span> ";
   return \yii\helpers\Html::submitButton($prefix . $text, $options);
}

if (!function_exists('boolval'))
{
   /**
    * Get the boolean value of a variable
    *
    * @param mixed The scalar value being converted to a boolean.
    * @return boolean The boolean value of var.
    */
   function boolval($var)
   {
       return !! $var;
   }
}

function isset_get($array, $key, $default = null)
{
   return isset($array[$key]) ? $array[$key] : $default;
}

function ifset($val, $default = null)
{
   return isset($val) ? $val : $default;
}

function dump()
{
   $args = func_get_args();
   ob_start(function($buffer){
      $ret = '<pre>' . $buffer;
      //$ret = preg_replace('/\n/', '<br/>', $ret);
      return $ret . '</pre>';
   });
   foreach ($args as $idx => $a)
   {
      if (is_scalar($a))
      {
         echo $a;
      }
      else
      {
         var_dump($a);
      }
   }
   ob_end_flush();
}

?>