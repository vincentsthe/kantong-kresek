<?php

Yii::import('ext.Utilities');

class InventoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/inventoryLayout';
	
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'view', 'delete', 'create','assign', 'listUnspecified', 'updateHarga', 'pindah', 'choosePindah', 'minimum', 'minimumKhusus', 'listStok', 'detailStock'),
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
		$this->active = 'view';
		
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
		$this->active = 'create';
		
		$model=new Inventory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
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
	public function actionAssign($id)
	{
		$this->active = 'list';
		
		$model=$this->loadModel($id);
		$assignForm = new AssignItemForm;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='assign-item-form') {
			echo CActiveForm::validate($assignForm);
			Yii::app()->end();
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['AssignItemForm']))
		{
			$assignForm->attributes=$_POST['AssignItemForm'];
			if($assignForm->validate()) {
				if (($assignForm->jumlah <= $model->jumlah_barang) && ($assignForm->jumlah > 0)) {
					$destination = Cabang::getCabangById($assignForm->lokasi);
					$manager = new InventoryManager($model);
					
					$newManager = $manager->pindah($destination, $assignForm->jumlah);
					$newManager->setHarga($assignForm);
					
					Yii::app()->user->setFlash("success", "Barang berhasil diregistrasi.");
					$this->redirect(array('index'));
				} else {
					Yii::app()->user->setFlash("error", "Jumlah barang tidak mencukupi");
				}
			} else {
				Yii::app()->user->setFlash("error", "Input tidak valid.");
			}
		}

		$this->render('assign',array(
			'barang'=>$model,
			'model'=>$assignForm,
		));
	}
	
	public function actionUpdateHarga($id) {
		$this->active = "index";
		
		$inventory = $this->loadModel($id);
		$model = UpdateInventoryHargaForm::newHargaForm($inventory);
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='harga-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		if(isset($_POST['UpdateInventoryHargaForm'])) {
			$model->attributes = $_POST['UpdateInventoryHargaForm'];
			$manager = new InventoryManager($inventory);
			$manager->setHarga($model);
			
			if($inventory->save()) {
				Yii::app()->user->setFlash('success', "Harga berhasil diedit.");
				$this->redirect(array('index'));
			} else {
				throw new CHttpException(500, "Internal Error");
			}
		}
		
		$this->render('updateHarga', array(
			'model' => $model,
			'barang' => $inventory,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->active = 'delete';
		
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
		$this->active = 'index';
		$criteria = new CDbCriteria;
		$criteria->condition = "lokasi IS NOT NULL AND harga_minimum IS NOT NULL AND harga_minimum_khusus IS NOT NULL";
		
		if(isset($_GET['filter'])) {
			$criteria->addCondition("nama_barang LIKE '%" . $_GET['filter'] . "%'");
		}
		
		if(isset($_GET['lokasi'])) {
			$criteria->addCondition("lokasi=" . $_GET['lokasi']);
		}
		
		$dataProvider=new CActiveDataProvider('Inventory',array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 20,
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'listCabang'=>Cabang::model()->findAll(),
		));
	}
	
	public function actionListUnspecified() {
		$this->active = 'list';
		
		$criteria = new CDbCriteria;
		$criteria->condition = "lokasi IS NULL OR harga_minimum IS NULL OR harga_minimum_khusus IS NULL";
		
		if(isset($_GET['filter'])) {
			$criteria->addCondition("nama_barang LIKE %" . $_GET['filter'] . "%");
		}
		
		$dataProvider = new CActiveDataProvider('Inventory', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 20,
			),
		));
		
		$this->render('listUnregistered', array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionPindah() {
		$this->active = "pindah";
		$criteria = new CDbCriteria;
		$criteria->condition = "lokasi IS NOT NULL AND harga_minimum IS NOT NULL AND harga_minimum_khusus IS NOT NULL";
		
		if(isset($_GET['filter'])) {
			$criteria->addCondition("nama_barang LIKE '%" . $_GET['filter'] . "%'");
		}
		
		if(isset($_GET['lokasi'])) {
			$criteria->addCondition("lokasi=" . $_GET['lokasi']);
		}
		
		$dataProvider=new CActiveDataProvider('Inventory',array(
				'criteria' => $criteria,
				'pagination' => array(
						'pageSize' => 20,
				),
		));
		$this->render('pindah',array(
				'dataProvider'=>$dataProvider,
				'listCabang'=>Cabang::model()->findAll(),
		));
	}
	
	public function actionChoosePindah($id) {
		$this->active = "pindah";
		$barang = $this->loadModel($id);
		$model = new PindahInventoryForm;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='pindah-form') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
		}
		
		if(isset($_POST['PindahInventoryForm'])) {
			$model->attributes = $_POST['PindahInventoryForm'];
			if($model->validate()) {
				if(($model->jumlah > 0) && ($model->jumlah <= $barang->jumlah_barang)) {
					$cabang = Cabang::getCabangById($model->lokasiTujuan);
					
					$manager = new InventoryManager($barang);
					$manager->pindah($cabang, $model->jumlah);
					Yii::app()->user->setFlash('success', $model->jumlah . " " . $barang->nama_barang . " berhasil dipindahkan");
					
					$this->redirect(array('index'));
				} else {
					Yii::app()->user->setFlash('error', 'Jumlah barang tidak mencukupi.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'Masukan tidak valid!');
			}
		}
		
		$this->render('choosePindah', array(
			'barang' => $barang,
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inventory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inventory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inventory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//ajax
	public function actionMinimum() {
		$invoiceId = $_POST['invoiceId'];
		$lokasiId = $_POST['tujuan'];
		$namaBarang = $_POST['namaBarang'];
		
		$criteria = new CDbCriteria;
		$criteria->condition = "invoice_id=" . $invoiceId . " AND lokasi=" . $lokasiId . " AND nama_barang='" . $namaBarang . "'";

		$inventory = Inventory::model()->find($criteria);
		
		if($inventory == null) {
			echo "-";
		} else {
			echo Utilities::currency($inventory->harga_minimum);
		}
		Yii::app()->end();
	}
	
	//ajax
	public function actionMinimumKhusus() {
		$invoiceId = $_POST['invoiceId'];
		$lokasiId = $_POST['tujuan'];
		$namaBarang = $_POST['namaBarang'];
	
		$criteria = new CDbCriteria;
		$criteria->condition = "invoice_id=" . $invoiceId . " AND lokasi=" . $lokasiId . " AND nama_barang='" . $namaBarang . "'";
	
		$inventory = Inventory::model()->find($criteria);
	
		if($inventory == null) {
			echo "-";
		} else {
			echo Utilities::currency($inventory->harga_minimum_khusus);
		}
		Yii::app()->end();
	}
	
	public function actionListStok($page=0) {
		$this->active = "stock";
		$location = 0;
		$filter = "";
		
		if(isset($_GET['lokasi'])) {
			$location = $_GET['lokasi'];
		}
		if(isset($_GET['filter'])) {
			$filter = $_GET['filter'];
		}
		
		$listStok = Stok::getStok($location, $filter, $page);
		$pageCount = Stok::getPageCount($location, $filter);
		$this->render('listStock', array(
			'listCabang'=>Cabang::model()->findAll(),
			'listStock' => $listStok,
			'pageCount' => $pageCount,
			'currentPage' => $page,
		));
	}
	
	public function actionDetailStock($name) {
		$this->active = "stock";
		
		$laporan = new Laporan($name);
		
		$locationInfo = $laporan->getLocationSum();
		$reportInfo = $laporan->getReport();
		
		$this->render('detailStock', array(
			'name' => $name,
			'locationInfo' => $locationInfo,
			'reportInfo' => $reportInfo,
		));
	}
}
