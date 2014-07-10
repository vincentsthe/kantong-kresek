<?php

class AccountingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/accountingLayout';
	public $active;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
		$this->active = "index";
		
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
		$this->active = "create";
		
		$model=new Accounting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Accounting']))
		{
			$model->attributes=$_POST['Accounting'];
			if($model->save())
				$this->redirect(array('index'));
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
		$this->active = "update";
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Accounting']))
		{
			$model->attributes=$_POST['Accounting'];
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
		$this->active = "delete";
		
		$this->loadModel($id)->delete();
		
		$this->redirect(array("admin"));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->active = "index";
		
		$dataProvider=new CActiveDataProvider('Accounting', array(
			'pagination' => array(
				'pageSize'=>40,
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionNewCode() {
		$this->active = "newCode";
		
		$code = new KodeAccounting;
		
		if(isset($_POST['KodeAccounting'])) {
			$code->attributes = $_POST['KodeAccounting'];
			
			if($code->save()) {
				Yii::app()->user->setFlash("success", "Kode berhasil dibuat.");
				$this->redirect("listCode");
			}
		}
		
		$this->render('newCode', array(
			'model' => $code,
		));
	}
	
	public function actionListCode() {
		$this->active = "listCode";
		
		$dataProvider = new CActiveDataProvider("KodeAccounting");
		
		$this->render("listCode", array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Accounting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Accounting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Accounting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
