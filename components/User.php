<?php
namespace app\components;

/**
 * @inheritdoc
 */
class User extends \auth\components\User
{
   
   /**
	 * Check the identity class for getters.
    * @inheritdoc
	 */
   public function __get($name)
   {
      $getter = 'get' . $name;
      if (method_exists($this->identity, $getter))
      {
         // get property of identity
         return $this->identity->$getter();
      }
      return parent::__get($name);
   }
    
   /**
	 * Check the identity class for setters.
    * @inheritdoc
	 */
   public function __set($name, $value)
   {
      $setter = 'set' . $name;
      if (method_exists($this->identity, $setter))
      {
         // set property of identity
         $this->identity->$setter($value);
         
         return;
      }
      parent::__set($name, $value);
   }
   
   /**
	 * @inheritdoc
	 */
	public $identityClass = 'app\models\User';
   
}
?>