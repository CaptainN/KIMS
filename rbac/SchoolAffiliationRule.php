<?
namespace app\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user passed is affiliated with a given school Id.
 *
 * A given user has one primary role (admin, staff, etc.), set via 
 * [[Yii::$app->authManager->assign]].  Only superAdmins and people affiliated
 * with a school, with sufficient privileges, are able to perform restricted actions.
 *
 * @author sycdan 2014-06-20
 */
class SchoolAffiliationRule extends Rule
{
   /**
    * @inheritdoc
    */
   public function execute($item, $params)
   {
      //dump('Params: ', $params);
      //dump(Yii::$app->user->identity->username);
      //dump('Auth Item: ', $item);
      
      if (Yii::$app->user->can('changeSchool')) return true;
      
      // check whether the user has any affiliation with the target school
      $userId = $params['user'];
      $schoolId = $params['school'];
      $userSchoolId = Yii::$app->user->identity->schoolId;
      //dump('User SChool: ', $userSchoolId);
      return isset($userSchoolId) ? $userSchoolId === $schoolId : false;
   }
   
   public $name = 'isAffiliatedWithSchool';
}
?>