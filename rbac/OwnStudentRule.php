<?php
namespace app\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * @author sycdan 2014-07-04
 */
class OwnStudentRule extends Rule
{
   /**
    * @inheritdoc
    */
   public function execute($item, $params)
   {
      //dump('Params: ', $params);
      //dump('Auth Item: ', $item);
      
      if (Yii::$app->user->can('changeSchool')) return true;
      
      $student = $params['student']; // model instance
      $userSchoolId = Yii::$app->user->schoolId;
      //dump('User School: ', $userSchoolId);
      if ($student->contract_school_id === $userSchoolId) return true;
      
      // check for affiliation with the user's school
      $affiliation = $student->getAffiliation();
      if (!isset($affiliation)) return false;
      
      // check if it's the contract affiliation
      if ($affiliation->isContract) return true;
      
      // allow the anchor days to be changed by admins in another school
      $attribute = $params['attribute'];
      $haystack = ['handAnchorId', 'weaponAnchorId'];
      if (isset($attribute) && in_array($attribute, $haystack)) return true;
   }
   
   public $name = 'isOwnStudent';
}
?>