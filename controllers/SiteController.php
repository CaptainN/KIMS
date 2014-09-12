<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
   public function behaviors()
   {
      return [
         'access' => [
            'class' => AccessControl::className(),
            'only' => ['login', 'logout', 'index'],
            'rules' => [
               [
                  'actions' => ['login'],
                  'roles' => ['?'],
                  'allow' => true,
               ],
               [
                  'actions' => ['logout', 'index'],
                  'roles' => ['@'],
                  'allow' => true,
               ],
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
               'logout' => ['post'],
            ],
         ],
      ];
   }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

   public function actionIndex()
   {
      return $this->render('index');
   }

   /*public function actionLogin()
   {
      // if an authenticated user is trying to log in again, send them home
      if (!Yii::$app->user->isGuest)
      {
         return $this->goHome();
      }

      // attempt to log the user in with their posted credentials
      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login())
      {
         // if login is successful, reset the attempts
         $this->setLoginAttempts(0);
         
         // return the authenticated user whence they came
         return $this->goBack();
      }
      
      
        
      //if login is not successful, increase the attempts
		$this->setLoginAttempts($this->getLoginAttempts() + 1);
        
      return $this->render('login', [
         'model' => $model,
      ]);

   }
    
   private function getLoginAttempts()
	{
		return Yii::$app->getSession()->get($this->loginAttemptsVar, 0);
	}

	private function setLoginAttempts($value)
	{
		Yii::$app->getSession()->set($this->loginAttemptsVar, $value);
	}

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    */

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

   //private $loginAttemptsVar = '__LoginAttemptsCount';
}
