<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Student;
use app\models\Affiliation;
use app\models\Role;
use app\models\StudentPhone;
use app\models\search\StudentSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use dosamigos\editable\EditableAction;
use dosamigos\grid\ToggleAction;
use yii\helpers\ArrayHelper;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends \app\components\KimsController
{

   public function behaviors()
   {
      return [
         'access' => [
            'class' => AccessControl::className(),
            'rules' => [
               // All logged in users ('@') have access
               // Guests ('?') do not have access
               ['allow' => true, 'roles' => ['@']],
               ['allow' => false, 'roles' => ['?']],
            ],
         ],
         'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
               'delete' => ['post'],
            ],
         ],
      ];
   }

   /**
    * Called when inline edits are made from the summary grid
    * @return mixed ajax response
    * @throws ForbiddenHttpException
    */
   public function actionEditable()
   {
      $accessParams = [
         'student' => Student::findOne(Yii::$app->request->post('pk')),
         'attribute' => Yii::$app->request->post('name'),
      ];
      if (Yii::$app->user->can('updateStudent', $accessParams))
      {
         //!!! Dirty hack
         // the checklist columns don't always set post['value'], so force it
         if (!array_key_exists('value', $_POST))
         {
            // should really check the name of the attribute and only set this
            // to a blank array when we know the attribute expects one.
            $_POST['value'] = [];
            Yii::$app->request->setBodyParams($_POST);
         }

         $action = new EditableAction('editable', $this, [
            'modelClass' => Student::className(),
            'forceCreate' => false,
         ]);
         return $action->run();
      } else
      {
         throw new ForbiddenHttpException(
         Yii::t('app', 'You are not authorized to perform this action.'));
      }
   }

   /**
    * Toggles a binary field from the summary grid
    * @param type $id
    * @param type $attribute
    * @return mixed ajax response
    * @throws ForbiddenHttpException
    */
   public function actionToggle($id, $attribute)
   {
      $accessParams = ['student' => Student::findOne($id)];
      if (Yii::$app->user->can('updateStudent', $accessParams))
      {
         $action = new ToggleAction('toggle', $this, [
            'modelClass' => Student::className(),
         ]);
         return $action->run($id, $attribute);
      } else
      {
         throw new ForbiddenHttpException(
         Yii::t('app', 'You are not authorized to perform this action.'));
      }
   }

   /**
    * Lists all Student models in a sumamry grid where inline edits can be made.
    * @return mixed
    */
   public function actionIndex()
   {
      $searchModel = new StudentSearch;
      $params = Yii::$app->request->getQueryParams();
      $dataProvider = $searchModel->search($params);
      $query = $dataProvider->query;

      // default to showing only actives
      if (!isset($searchModel->active))
      {
         $query->andFilterWhere(['student.active' => 1]);
      }

      // default to attendance sort
      if (!isset($params['sort']))
      {
         $query->orderBy([ // sort nulls last with "-field DESC"
            'division.ord' => SORT_ASC,
            '-`class_frequency`.`ord`' => SORT_DESC,
            '-`day`.`ord`' => SORT_DESC,
            '-`class`.`start_time`' => SORT_DESC,
            //'rank.ord' => SORT_DESC,
         ]);
      }

      if ($params['json'] && boolval($params['json']))
      {
         $data = $query->asArray()->all();
         return $this->renderJson($data);
      }

      return $this->render('index', [
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
   }

   public function actionCheckName($term)
   {
      $lname = Html::encode($term);
      $models = Student::find()
       ->where(['like', 'lname', "{$lname}%", false])
       ->all();
      return $this->renderAjax('name-conflict', [
          'models' => $models,
          'lname' => $lname,
      ]);
   }

   /**
    * Displays a single Student model.
    * @param integer $id
    * @return mixed
    */
   public function actionView($id)
   {
      return $this->render('view', [
          'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new Student model.
    * If creation is successful, the browser will be redirected to the either
    * the index or the create page to add another.
    * @return mixed
    */
   public function actionCreate()
   {
      $transaction = Yii::$app->db->beginTransaction();

      // Get the user's school and the current date.
      $schoolId = Yii::$app->user->schoolId;
      $today = date('Y-m-d');

      $student = new Student;
      $student->contract_school_id = $schoolId;
      $student->start_date = $today;

      if ($student->load(Yii::$app->request->post()) && $student->save())
      {
         // Affiliate the new student with the same school as the user
         $role = Role::find()->where(['like', 'name', 'student'])->one();
         $affiliation = new Affiliation();
         if ($affiliation->load(Yii::$app->request->post()))
         {
            $affiliation->student_id = $student->id;
            $affiliation->school_id = $schoolId;
            $affiliation->role_id = $role->id;
            $affiliation->date = $today;
            $affiliation->save();
         }

         /* Get the phone # that was posted along with the new student,
          * and assign it to the student via the newly-created ID.
          */
         $phone = new StudentPhone();
         if ($phone->load(Yii::$app->request->post()))
         {
            $phone->student_id = $student->id;
            $phone->save();
         }

         if ($affiliation->isSaved && $phone->isSaved)
         {
            $transaction->commit();

            $url = Html::a($student->name, ['update', 'id' => $student->id]);
            Yii::$app->session->setFlash('success', 'Student added: ' . $url);

            if (Yii::$app->request->post('then-add') !== null)
            {
               return $this->redirect(['create']);
            } elseif (Yii::$app->request->post('then-edit') !== null)
            {
               return $this->redirect(['update', 'id' => $student->id]);
            } else
            {
               return $this->redirect(['index']);
            }
         } else
         {
            $transaction->rollBack();
            
            $msg = 'Unable to create student: ';
            //!!! find a better way to extract the model errors
            $msg .= serialize($affiliation->errors);
            $msg .= serialize($phone->errors);
            Yii::$app->session->setFlash('error', $msg);
         }
      }

      return $this->render('create', [
          'model' => $student,
      ]);
   }

   /**
    * 
    * @param integer $id
    * @param string $type
    * @return string JSON map
    */
   public function actionAvailableClasses($id, $type = 'hand')
   {
      $student = $this->findModel($id);
      switch ($type)
      {
         case 'hand':
            $data = $student->handAnchors;
            break;

         case 'weapon':
            $data = $student->weaponAnchors;
            break;

         default:
            break;
      }

      return $this->renderJson(ArrayHelper::map($data, 'id', 'name'));
   }

   /**
    * Updates an existing Student model.
    * If update is successful, the browser will be redirected to the index page.
    * @param integer $id
    * @return mixed
    */
   public function actionUpdate($id)
   {
      $student = $this->findModel($id);

      if (!user()->can('updateStudent', ['student' => $student]))
      {
         setError('You are not authorized to update this student; please go back.');
         return $this->redirect(['index'], 403);
      }

      if ($student->load(Yii::$app->request->post()) && $student->save())
      {
         $affiliation = $student->affiliation;
         if ($affiliation->load(Yii::$app->request->post()))
         {
            if ($affiliation->save())
            {
               $link = Html::a($student->name, ['update', 'id' => $student->id]);
               $msg = 'Changes to ' . $link . ' saved successfully.';
               Yii::$app->session->setFlash('success', $msg);
               return $this->redirect(['index']);
            }
         }
      }

      return $this->render('update', [
          'student' => $student,
      ]);
   }

   /**
    * Deletes an existing Student model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
   public function actionDelete($id)
   {
      $student = $this->findModel($id);
      $accessParams = ['student' => $student];
      if (Yii::$app->user->can('deleteStudent', $accessParams))
      {
         $student->delete();

         return $this->redirect(['index']);
      }
   }

   /**
    * Finds the Student model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Student the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = Student::findOne($id)) !== null)
      {
         return $model;
      } else
      {
         throw new NotFoundHttpException('The requested student does not exist.');
      }
   }

}
