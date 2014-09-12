<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Set up auth items, rules & roles.
 *
 * @author ds 2014-06-19
 */

class RbacController extends Controller
{  
   public function options($actionId)
   {
      $options = [];
      switch ($actionId)
      {
         case 'permission':
            $options[] = 'description';
            $options[] = 'rule';
            $options[] = 'childOf';
            break;
         case 'assign':
            $options[] = 'ruleName';
            break;
      }
      return array_merge($options, parent::options($actionId));
   }
   
   public function actionIndex()
   {
      echo 'Run init to create roles and permisions.' . PHP_EOL;
   }
   
   /* Assign roles to users
    * @param roleName
    * @param userId returned by IdentityInterface::getId()
    */
   public function actionAssign($roleName, $userId)
   {
      $auth = Yii::$app->authManager;
      
      $role = $this->GetRole($roleName);
      $rule = $this->GetRule($this->ruleName);
      
      $auth->assign($role, $userId, $rule);
   }
   
   public function actionPermission($name)
   {
      $auth = Yii::$app->authManager;
      $obj = $this->GetPermission($name);
      if (isset($obj))
      {
         if (isset($this->description))
         {
            $obj->description = $this->description;
         }
         if (isset($this->rule))
         {
            $obj->ruleName = $this->rule;
         }
         $auth->update($name, $obj);
      }
      
      $parentName = $this->childOf;
      if (isset($parentName))
      {
         // look for a role or permission with the parent name
         $parent = $auth->getRole($parentName);
         if (!isset($parent)) $parent = $auth->getPermission($parentName);
         if (!isset($parent))
         {
            echo 'parent does not exist';
            return;
         }
         $auth->addChild($parent, $obj);
      }
      
      echo 'Permission updated.' . PHP_EOL;
   }
   
   public function actionInit()
   {
      $auth = Yii::$app->authManager;
      
      // create rules
      $rules = ['\app\rbac\SchoolAffiliationRule'];
      foreach ($rules as $v)
      {
         $this->SetRule(new $v);
      }
      return;
      
      // create roles
      echo PHP_EOL . '---ROLES---' . PHP_EOL;
      $roles = ['admin', 'schoolAdmin', 'staff'];
      foreach ($roles as $roleName)
      {
         $this->actionCreate('role', $roleName);
      }
      
      // create permissions [[permission, description]]
      echo PHP_EOL . '---PERMISSIONS---' . PHP_EOL;
      $permissions = ['printAttendance'];
      foreach ($permissions as $v)
      {
         if (is_array($v))
         {
            $permName = $v[0];
            $permDesc = $v[1];
         }
         else
         {
            $permName = $v;
            $permDesc = $v;
         }
         $this->actionCreate('permission', $permName, $permDesc);
      }
      
      // map roles to permissions [[role, [permission1, permission2]]
      echo PHP_EOL . '---ASSIGNMENTS---' . PHP_EOL;
      $assignments = [
         ['superAdmin',    ['printAttendance']],
         ['schoolAdmin',   ['printAttendance']],
         ['staff',         ['printAttendance']],
      ];
      foreach ($assignments as $v)
      {
         $roleName = $v[0];
         echo '`' . $roleName . '`... ';
         $permisions = $v[1];
         $role = $auth->getRole($roleName);
         if (!isset($role))
         {
            echo 'role does not exist!' . PHP_EOL;
            continue;
         }
         foreach ($permisions as $p)
         {
            echo PHP_EOL . '... adding permission `' . $p . '`... ';
            $perm = $auth->getPermission($p);
            if (!isset($perm))
            {
               echo 'does not exist!' . PHP_EOL;
            }
            $child = $auth->getChild($role, $perm);
            if (!isset($child))
            {
               $auth->addChild($role, $perm);
            }
         }
         echo 'done.' . PHP_EOL;
      }

      echo PHP_EOL . 'Finished.' . PHP_EOL;
      /*
      // add "reader" role and give this role the "readPost" permission
      $reader = $auth->createRole('reader');
      $auth->add($reader);
      $auth->addChild($reader, $readPost);

      // add "author" role and give this role the "createPost" permission
      // as well as the permissions of the "reader" role
      $author = $auth->createRole('schoolAdmin');
      $auth->add($author);
      $auth->addChild($author, $createPost);
      $auth->addChild($author, $reader);

      // add "admin" role and give this role the "updatePost" permission
      // as well as the permissions of the "author" role
      
      $auth->add($admin);
      $auth->addChild($admin, $updatePost);
      $auth->addChild($admin, $author);

      
      // usually implemented in your User model.
      $auth->assign($reader, 10);
      $auth->assign($author, 14);
      $auth->assign($superAdmin, 1);
      */
   }
   
   /**
    * @param string type of item (role / permission)
    * @param string name of the item
    * @param string description of the permission
    */
   public function actionCreate($type, $name, $description = null)
   {
      $auth = Yii::$app->authManager;
      $item = null;
      
      switch ($type)
      {
         case 'role':
            echo 'Creating `' . $name . '` role... ';
            $item = $auth->getRole($name);
            if (isset($item))
            {
               echo 'already exists.' . PHP_EOL;
               return self::ERROR_AUTH_ITEM_ALREADY_EXISTS;
            }
            $item = $auth->createRole($name);
            break;
         case 'permission':
            echo 'Creating `' . $name . '` permission... ';
            $item = $auth->getPermission($name);
            if (isset($item))
            {
               echo 'already exists.' . PHP_EOL;
               return self::ERROR_AUTH_ITEM_ALREADY_EXISTS;
            }
            $item = $auth->createPermission($name);
            break;
         case 'rule':
            $this->SetRule(new $name);
            return;
            break;
         default:
            echo 'Invalid type `' . $type . '`' . PHP_EOL;
            return self::ERROR_INVALID_INPUT;
      }
      
      if (isset($description))
      {
         $item->description = $description;
      }
      
      $auth->add($item);
      
      echo 'success.' . PHP_EOL;
      return 0;
   }
   
   private function GetPermission($name)
   {
      $auth = Yii::$app->authManager;
      $perm = $auth->getPermission($name);
      if (!isset($perm))
      {
         if ($this->Confirm('Create `' . $name . '` permission?'))
         {
            $perm = $auth->createPermission($name);
            $auth->add($perm);
         }
         else
         {
            return null;
         }
      }
      return $perm;
   }
   
   private function GetRole($name)
   {
      $auth = Yii::$app->authManager;
      $role = $auth->getRole($name);
      if (!isset($role))
      {
         if ($this->Confirm('Create `' . $name . '` role?'))
         {
            $role = $auth->createRole($name);
         }
         else
         {
            return null;
         }
      }
      return $role;
   }
   
   /**
    * Retrieve/create a rule;
    */
   private function GetRule($name)
   {
      $auth = Yii::$app->authManager;
      $rule = $auth->getRule($name);
      if (!isset($rule))
      {
         echo 'You must create the `' . $name . '` rule first.' . PHP_EOL;
         return null;
      }
      return $rule;
   }
   
   /**
    * Public Variables (global command parameters)
    */
   public $rule = null;
   public $ruleName = null;
   public $description = null;
   public $role = null;
   public $permission = null;
   public $childOf = null;
   
   /**
    * Private Variables
    */
   private $auth;
   const ERROR_NONE = 0;
   const ERROR_UNKNOWN = 1;
   const ERROR_INVALID_INPUT = 2;
   const ERROR_NONEXISTANT_AUTH_ITEM = 3;
   const ERROR_AUTH_ITEM_ALREADY_EXISTS = 4;
}