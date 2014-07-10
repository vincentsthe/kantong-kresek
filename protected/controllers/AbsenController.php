<?php
Yii::import('ext.Utilities');

class AbsenController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/absenLayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('absen'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('list', 'index'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Absen;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Absen']))
		{
			$model->attributes=$_POST['Absen'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Absen']))
		{
			$model->attributes=$_POST['Absen'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Absen');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionList() {
		if(!isset($_POST['Tanggal'])) {
			$this->render("list");
		} else {
			$startTime = Utilities::beginDay(Utilities::formattedDateToTimestamp($_POST["Tanggal"], "%d-%m-%Y"));
			$endTime = $startTime + (24 * 60 * 60);
			
			$criteria1 = new CDbCriteria;
			$criteria2 = new CDbCriteria;
			
			$criteria1->condition = "type=" . Absen::$TYPE_DATANG . " AND timestamp>=" . $startTime . " AND timestamp<" . $endTime;
			$criteria2->condition = "type=" . Absen::$TYPE_PULANG . " AND timestamp>=" . $startTime . " AND timestamp<" . $endTime;
			
			$absenMasuk = new CActiveDataProvider('Absen', array(
				'criteria' => $criteria1,
			));
			$absenPulang = new CActiveDataProvider('Absen', array(
				'criteria' => $criteria2,
			));
			
			$this->render("list", array(
				'absenMasuk' => $absenMasuk,
				'absenPulang' => $absenPulang,
				'tanggal' => $_POST['Tanggal']
			));
		}
	}
	
	public function actionAbsen() {
		if(isset($_POST['username']) && isset($_POST['token'])) {
			$criteria = new CDbCriteria;
			
			$criteria->condition = "username='" . $_POST['username'] . "'";
			
			$user = User::model()->find($criteria);
			
			if($user != null) {
				Absen::doAbsen($user->id);
				
				Yii::app()->user->setFlash("success", "Absen berhasil");
				$this->redirect("/site/login");
			} else {
				throw new CHttpException(404, "Username not found");
			}
		} else {
			throw new CHttpException(400, "Error");
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Absen('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Absen']))
			$model->attributes=$_GET['Absen'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Absen the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Absen::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Absen $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='absen-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
