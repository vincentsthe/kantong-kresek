<?php

Yii::import('ext.Utilities');

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/userLayout';
	
	public $active = "";
	public $mainLayoutActive = "user";

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
				'actions'=>array('index','view','create','update','delete', 'listLogin', 'createPermission', 'removePermission'),
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
		$this->active = "view";
		
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
		
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()) {
				Yii::app()->user->setFlash("success", "User berhasil dibuat.");
				$this->redirect(array('view','id'=>$model->id));
			} else {
				Yii::app()->user->setFlash("error", "Input tidak valid.");
			}
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
		
		$model->password = '';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if(strlen($model->password) > 0) {
				$model->password = Utilities::hashPassword($model->password);
			}
			
			if($model->save()) {
				Yii::app()->user->setFlash("success", "User berhasil diedit.");
				$this->redirect(array('view','id'=>$model->id));
			} else {
				Yii::app()->user->setFlash("error", "Masukan tidak valid.");
			}
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
		Yii::app()->user->setFlash("success", "User berhasil dihapus.");
		$this->loadModel($id)->delete();
		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->active = "index";
		
		$criteria = new CDbCriteria;
		
		if(isset($_GET['filter'])) {
			$criteria->condition = "username LIKE :filter OR fullname LIKE :filter";
			$criteria->params = array(':filter' => "%" . $_GET['filter'] . "%");
		}
		
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria' => $criteria
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'pagination'=>array(
				'pageSize'=>15,
			)
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->active = "admin";
		
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionListLogin() {
		$this->active = "listLogin";
		
		$loginPermission = array();
		foreach(Cabang::getAllCabang() as $cabang) {
			$loginPermission[$cabang->nama] = array_map(function($d) {return $d->user;}, CabangUser::getAllUserByCabang($cabang));
		}
		
		$this->render('loginPermission', array(
			'loginPermission' => $loginPermission,
		));
	}
	
	public function actionCreatePermission() {
		$this->active = "listLogin";
		
		$form = new AddLoginPermissionForm;
		
		if(isset($_POST['AddLoginPermissionForm'])) {
			$form->attributes = $_POST['AddLoginPermissionForm'];
			
			$loginController = new LoginPermission(User::getUserById($form->user));
			$loginController->addPermision(Cabang::getCabangById($form->cabang));
			
			$this->redirect(array('listLogin'));
		}
		
		$this->render('createPermission', array(
			'model' => $form,
		));
	}
	
	public function actionRemovePermission($userId, $cabangName) {
		$loginPermission = new LoginPermission(User::getUserById($userId));
		$loginPermission->removePermission(Cabang::getCabangByName($cabangName));
		
		$this->redirect(array('listLogin'));
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
