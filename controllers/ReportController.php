<?php

namespace app\controllers;

use Yii;
use mPDF;
use app\models\Student;
use yii\helpers\ArrayHelper;


/**
 * ReportController for creating PDF reports.
 */
class ReportController extends \app\components\KimsController
{

   /**
    * Lists all reports.
    * @return mixed
    */
   public function actionIndex()
   {
       /*$searchModel = new AddressSearch;
       $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

       return $this->render('index', [
           'dataProvider' => $dataProvider,
           'searchModel' => $searchModel,
       ]);*/
   }
   
   /**
    * Creates a printable table of all active students not authorized to spar,
    * ordered by last name.
    */
   public function actionSparauth()
   {
      if (!Yii::$app->user->can('printAttendance'))
      {
         throw new ForbiddenHttpException(Yii::t('app',
          'You are not authorized to perform this action.'));
      }
      
      return "Not implemented yet.";
   }

   /**
    * Creates a printable table of all active students in a given school,
    * ordered by division.
    */
   public function actionAttendance()
   {
      if (!Yii::$app->user->can('printAttendance'))
      {
         throw new ForbiddenHttpException(Yii::t('app',
          'You are not authorized to perform this action.'));
      }
      $school = Yii::$app->user->school;
      $utsMonth = strtotime(Yii::$app->user->reportMonth);
      
      $minimumBlanks = 4;
      $rowsPerPage = 38;
      $rowHeight = 4.8;
      
      // define the columns to show in the table
      $columns = [
         [
          'attribute' => 'name',
          'header' => 'Name',
          'head-font-style' => 'B',
          'body-font-size' => 9,
          'width' => 40,
         ],
         [
          'attribute' => 'bestPhoneNumber',
          'header' => 'Phone',
          'head-font-style' => 'B',
          'body-font-size' => 9,
          'width' => 24,
         ],
         [
          'attribute' => 'handAnchor.name',
          'header' => 'Anc.',
          'head-font-style' => 'B',
          'body-font-size' => 8,
          'width' => 10,
         ],
         [
          'attribute' => 'dobAndAge',
          'header0' => 'DoB/',
          'header' => 'Age', 
          'head-font-style' => 'B',
          'body-font-size' => 8,
          'width' => 14,
         ],
      ];
      
      // add the days of the month to the column list
      $abbr = ['M', 'T', 'W', 'H', 'F', 'A', 'S'];
      $daysInMonth = date('t', $utsMonth);

      for ($i = 0; $i < $daysInMonth; $i++)
      {
         // get the date of day $i+1 in the month
         $date = strtotime(date('Y-m-', $utsMonth). ($i + 1));

         // get the abbreviation of the day name
         $day = $abbr[intval(date('N', $date))-1];
         $columns[] = [
          'head-font-size' => 8,
          'isDay' => true,
          'width' => 5,
          'header0' => $day,
          'header' => '' . ($i + 1),
          'border' => 1,
          'x' => null,
         ];
      }
      
      // add the notes column
      $columns[] = [
       'head-font-size' => 9,
       'head-font-style' => 'B',
       'width' => 22,
       'header0' => 'Notes/',
       'header' => 'Excusals',
       'x' => null,
      ];
      
      $pdf = new mPDF('c', 'Letter-L', 0, '', 6.25, 6.25, 10, 6.25, 6.25, 6.25, 'L');
      $header = array (
        'odd' => array (
          'L' => array (
            'content' => 'Attendance List: ' . date('F Y', $utsMonth),
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'sans serif',
            'color'=>'#000000'
          ),
          'C' => array (
            'content' => $school->name,
            'font-size' => 14,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color'=>'#000000'
          ),
          'R' => array (
            'content' => '',
            'font-size' => 9,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color'=>'#000000'
          ),
          'line' => 0,
        ),
        'even' => array ()
      );
      $pdf->SetHeader($header);
      
      $newPage = function($division)
       use (&$pdf, &$utsMonth, &$rowsPerPage, &$columns, $rowHeight)
      {
         $lMargin = $pdf->lMargin;
         
         $pdf->AddPage('L');
         
         // write the division header
         $pdf->SetFont('sans serif' , 'BU', 12);
         $pdf->WriteCell(0, 6, 'Division ' . $division, 0, 0, 'C');
         $pdf->Ln();
         
         // write first line of column headers
         foreach ($columns as $c)
         {
            $text = isset_get($c, 'header0', '');
            $width = isset_get($c, 'width', 0);
            
            // print the day headers smaller
            if (isset($c['isDay']))
            {
               $fontSize = 8;
               $fontStyle = '';
            }
            else
            {
               $fontSize = isset_get($c, 'head-font-size', 10);
               $fontStyle = isset_get($c, 'head-font-style', '');
            }
            $pdf->SetFont('' , $fontStyle, $fontSize);
            
            // append text to a blank string to convert nulls
            $pdf->WriteCell($width, 2, $text, 0, 0, 'C');
         }
         $pdf->Ln();
         
         // write second line of column headers
         foreach ($columns as $i => $c)
         {
            $text = isset_get($c, 'header', '');
            $width = isset_get($c, 'width', 0);
            
            // print the day headers smaller
            if (isset($c['isDay']))
            {
               $fontSize = 8;
               $fontStyle = '';
            }
            else
            {
               $fontSize = isset_get($c, 'head-font-size', 10);
               $fontStyle = isset_get($c, 'head-font-style', '');
            }
            $pdf->SetFont('' , $fontStyle, $fontSize);
            
            // record this column's x position
            $columns[$i]['x'] = $pdf->x;
            
            $pdf->WriteCell($width, $rowHeight, $text, 0, 0, 'C');            
         }
         $pdf->Ln();
         
         // underline headers
         $pdf->Line($lMargin, $pdf->y, $lMargin + $pdf->pgwidth, $pdf->y);
         
         // fill every other row
         $pdf->SetFillColor(128, 255, 255);
         for ($i = 0; $i < $rowsPerPage; ++$i)
         {
            $rowY = $pdf->y + ($i * $rowHeight);
            
            if (0 !== $i % 2)
            {
               $pdf->RoundedRect($lMargin, $rowY, $pdf->pgwidth, $rowHeight, 0, 'F');
            }
            
            // underline all rows
            $pdf->Line($lMargin, $rowY + $rowHeight,
             $lMargin + $pdf->pgwidth, $rowY + $rowHeight);
         }
         
         // fill every other day column
         $pdf->SetFillColor(192, 192, 192);
         $allRowsHeight = $rowsPerPage * $rowHeight;
         foreach ($columns as $i => $c)
         {
            $x = $c['x'];
            $y = $pdf->y;
            $width = $c['width'];
            
            if (0 === $i % 2 && isset($c['isDay']))
            {
               // fill
               $pdf->RoundedRect($x, $y, $width, $allRowsHeight, 0, 'F');
            }
         }
         
         // underline all rows
         for ($i = 0; $i < $rowsPerPage; ++$i)
         {
            $rowB = $pdf->y + ($i * $rowHeight) + $rowHeight;
            $pdf->Line($lMargin, $rowB, $lMargin + $pdf->pgwidth, $rowB);
         }
         
         // Set the font for the rest of the table
         $pdf->SetFont('sans serif' , '', 9);
      };
      
      $fillPageWithBlanks = function()
       use (&$pdf, &$columns, &$printedRows, &$rowsPerPage, &$minimumBlanks,
       &$printBlanks, &$lastDivision, &$newPage)
      {
         $remainder = $printedRows % $rowsPerPage;
         $availableRows = $remainder > 0 ? $rowsPerPage - $remainder : 0;
         $printBlanks($availableRows);
         if ($availableRows < $minimumBlanks)
         {
            $newPage($lastDivision);
            $printBlanks($rowsPerPage);
         }
      };
      
      $printBlanks = function($rowCount) use (&$printModel)
      {
         while ($rowCount-- > 0)
         {
            $printModel(null);
         }
      };
      
      $printModel = function($model)
       use (&$pdf, &$columns, &$printedRows, $rowHeight)
      {
         foreach ($columns as $c)
         {
            $attr = $c['attribute'];
            $text = null;
            if (isset($model) && isset($attr))
            {
               $text = ArrayHelper::getValue($model, $attr);
            }
            
            $border = isset($c['border']) ? $c['border'] : 0;
            
            $fontSize = isset_get($c, 'body-font-size', 9);
            $fontStyle = isset_get($c, 'body-font-style', '');
            
            $pdf->SetFont('', $fontStyle, $fontSize);
            
            $pdf->WriteCell($c['width'], $rowHeight, '' . $text, $border);
         }
         $pdf->Ln();
         ++$printedRows;
      };
      
      // query for all active students in this school (excluding instructors)
      $q = Student::find();
      $q->joinWith('affiliation.handAnchor.day');
      $q->joinWith('affiliation.handAnchor.frequency');
      $q->joinWith('affiliation.role');
      $q->joinWith('promotions.rank');
      $q->joinWith('division'); 
      $q->andWhere(['student.active' => 1]);
      $q->andWhere(['affiliation.school_id' => $school->id]);
      $q->andWhere(['between', 'role.ord', 0, 7000]);
      $q->orderBy([
         'division.ord' => SORT_ASC,
         '-`class_frequency`.`ord`' => SORT_DESC,
         '-`day`.`ord`' => SORT_DESC,
         '-`class`.`start_time`' => SORT_DESC,
         'rank.ord' => SORT_DESC,
      ]);
      
      $lastDivision = '';
      $printedRows = 0;
      $models = $q->all();
      foreach ($models as $model)
      {
         $division = $model->division->name;
         if ($division !== $lastDivision)
         {
            if ($printedRows > 0) // only if we're not doing the first row
            {
               $fillPageWithBlanks();
            }
            $newPage($division);
         }elseif (0 === $printedRows % $rowsPerPage && $printedRows > 0)
         {
            // if we ran out of space on the page, start a new one
            $newPage($lastDivision);
         }
         $printModel($model); // will increment printedRows
         $lastDivision = $division;
      }
      $fillPageWithBlanks(); //ensure blanks after last division
      
      return $pdf->Output();
   }

}
