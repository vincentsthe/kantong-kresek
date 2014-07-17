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
				'actions'=>array('list'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionList() {
		if(!isset($_POST['Tanggal'])) {
			$this->render("list");
		} else {
			$time = Utilities::formattedDateToTimestamp($_POST["Tanggal"], "%d-%m-%Y");
			
			$absenMasuk = Absen::getAbsenMasuk($time);
			$absenPulang = Absen::getAbsenPulang($time);
			
			$this->render("list", array(
				'absenMasuk' => $absenMasuk,
				'absenPulang' => $absenPulang,
				'tanggal' => $_POST['Tanggal']
			));
		}
	}
	
	public function actionAbsen() {
		if(isset($_POST['username']) && isset($_POST['token'])) {
			if(User::usernameExist($_POST['username'])) {
				$user = User::getUserByUsername($_POST['username']);
				
				$absenChecker = new AbsenChecker($user);
				$absenChecker->doAbsen();
				
				Yii::app()->user->setFlash("success", "Absen berhasil");
				$this->redirect("/site/login");
			} else {
				Yii::app()->user->setFlash("error", "username tidak ditemukan");
				$this->redirect("/site/login");
			}
		} else {
			throw new CHttpException(400, "Error");
		}
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
