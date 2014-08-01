<?php
Yii::import('ext.Utilities');

class InvoicePenjualanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/invoicePenjualanLayout';
	
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
				'actions'=>array('index', 'view', 'delete', 'create','update','createNew','preview','chooseItem','addItem','pembayaran','final','doCreate','removeItem','report','listToday','cancel'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','delete','createNew','preview','chooseItem','addItem','pembayaran','final','doCreate','removeItem','listToday','cancel','view'),
				'users'=>array('@'),
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
		$invoice = $this->loadModel($id);
		
		if(!(Yii::app()->user->roles == "admin") && ($invoice->waktu_penerbitan < Utilities::getTodayTimeStamp())) {
			throw new CHttpException(403, "Not Authorized");
		}
		
		if(Yii::app()->user->roles == "admin") {
			$this->active = "index";
		} else {
			$this->active = "today";
		}
		
		$this->render('view',array(
			'invoice'=>$this->loadModel($id),
		));
	}
	
	public function actionCancel($id) {
		$invoice = $this->loadModel($id);
		
		if(!(Yii::app()->user->roles == "admin") && ($invoice->waktu_penerbitan < Utilities::getTodayTimeStamp())) {
			throw new CHttpException(403, "Not Authorized");
		}
		
		$invoice->cancel();
		
		if(Yii::app()->user->roles == "admin") {
			$this->redirect(array("index"));
		} else {
			$this->redirect(array("listToday"));
		}
	}
	
	public function actionCreateNew() {
		$session = new CHttpSession;
		$session->open();
		
		$session['penjualanPublisher']=new InvoicePenjualanPublisher(Yii::app()->user->location);
		
		if(Yii::app()->user->hasFlash('error')) {
			Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error'));
		}
		if(Yii::app()->user->hasFlash('success')) {
			Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success'));
		}
		
		$this->redirect(array('create'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher'])) {
			$this->redirect(array('createNew'));
		}
		
		$model=new PenjualanContactForm;

		if(isset($_POST['PenjualanContactForm']))
		{
			$model->attributes=$_POST['PenjualanContactForm'];
			if($model->validate()) {
				$session['penjualanPublisher']->fillContact($model);
				$this->redirect(array('preview'));
			} else {
				Yii::app()->user->setFlash('error', 'Input Tidak Valid.');
			}
		} else {
			$model = $session['penjualanPublisher']->getContact();
		}
		
		if(Yii::app()->user->hasFlash('error')) {
			Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error'));
		}
		if(Yii::app()->user->hasFlash('success')) {
			Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionPreview() {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasContact())) {
			$this->redirect(array('createNew'));
		}
		
		$this->render('preview', array(
			'contact'=>$session['penjualanPublisher']->getContact(),
			'listPenjualan'=>$session['penjualanPublisher']->getListBarang(),
		));
	}
	
	public function actionChooseItem() {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasContact())) {
			$this->redirect(array('createNew'));
		}
		
		$criteria = array();
		$criteria['lokasi'] = Yii::app()->user->location;
		
		$likeCriteria = array();
		if(isset($_GET['filter'])) {
			$likeCriteria['nama_barang'] = $_GET['filter'];
		}
		
		$this->render('chooseItem', array(
			'dataProvider' => Inventory::getDataProvider($criteria, $likeCriteria),
		));
	}
	
	public function actionAddItem($inventoryId) {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasContact())) {
			$this->redirect(array('createNew'));
		}
		
		$hargaForm = new AddPenjualanForm;
		$barang = Inventory::model()->findByPK($inventoryId);
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='addPenjualan-form') {
			echo CActiveForm::validate($hargaForm);
			Yii::app()->end();
		}
		
		if(isset($_POST['AddPenjualanForm'])) {
			$hargaForm->attributes = $_POST['AddPenjualanForm'];
			
			if($hargaForm->validate()) {
				if(($hargaForm->jumlah > 0) && ($hargaForm->jumlah <= $barang->jumlah_barang)) {
					$hargaMinimal = $barang->getHargaMinimal(Yii::app()->user->roles);
					
					if ($hargaForm->harga >= $hargaMinimal) {
						$penjualan = new PenjualanBaru($barang, $hargaForm->harga, $hargaForm->jumlah);
						$session['penjualanPublisher']->addBarang($penjualan);
						
						Yii::app()->user->setFlash('success', "Barang berhasil ditambahkan.");
						$this->redirect(array('preview'));
					} else {
						Yii::app()->user->setFlash('error', 'Harga lebih kecil dari harga minimum.');
					}
				} else {
					Yii::app()->user->setFlash('error', 'Jumlah tidak mencukupi.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'Masukan tidak benar.');
			}
		}
		
		$this->render('addItem', array(
			'barang' => $barang,
			'hargaForm' => $hargaForm,
		));
	}
	
	public function actionRemoveItem($inventory_id) {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasContact())) {
			$this->redirect(array('createNew'));
		}
		
		$session['penjualanPublisher']->removeBarangById($inventory_id);
		
		Yii::app()->user->setFlash('success', 'Barang berhasil dihapus dari daftar.');
		
		$this->redirect(array('preview'));
	}
	
	public function actionPembayaran() {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasContact())) {
			$this->redirect(array('createNew'));
		}
		
		$pembayaranForm = $session['penjualanPublisher']->getPembayaran();
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='pembayaranPenjualan-form') {
			echo CActiveForm::validate($pembayaranForm);
			Yii::app()->end();
		}
		
		if(isset($_POST['PembayaranPenjualanForm'])) {
			$pembayaranForm->attributes = $_POST['PembayaranPenjualanForm'];
			
			if($pembayaranForm->validate()) {
				$session['penjualanPublisher']->fillPembayaran($pembayaranForm);
				$this->redirect(array('final'));
			} else {
				Yii::app()->user->setFlash('error', "Input tidak valid.");
			}
		}
		
		$this->render('pembayaran', array(
			'contact' => $session['penjualanPublisher']->getContact(),
			'listPenjualan' => $session['penjualanPublisher']->getListBarang(),
			'pembayaranForm' => $pembayaranForm,
		));
	}
	
	public function actionFinal() {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasPembayaran())) {
			$this->redirect(array('createNew'));
		}
		
		$this->render('final', array(
			'invoice' => $session['penjualanPublisher']->getInvoice(),
			'listPenjualan' => $session['penjualanPublisher']->getListBarang(),
		));
	}
	
	public function actionDoCreate() {
		$this->active = "create";
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['penjualanPublisher']) || !($session['penjualanPublisher']->hasPembayaran())) {
			$this->redirect(array('createNew'));
		}
		
		try {
			$session['penjualanPublisher']->publishInvoice();
			$invoiceId = $session['penjualanPublisher']->getInvoice()->id;
		} catch(Exception $e) {
			throw new CHttpException(500, $e->getMessage());
		}
		
		$session->remove('penjualanPublisher');	
		Yii::app()->user->setFlash("success", "Invoice berhasil diterbitkan.");
		$this->redirect(array('view', "id"=>$invoiceId));
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

		if(isset($_POST['InvoicePenjualan']))
		{
			$model->attributes=$_POST['InvoicePenjualan'];
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
		$this->active = "index";
		
		$likeCriteria = array();
		if(isset($_GET['filter'])) {
			$likeCriteria['nomor'] = $_GET['filter'];
			$likeCriteria['nama_pembeli'] = $_GET['filter'];
			$likeCriteria['nama_terkirim'] = $_GET['filter'];
		}
		
		$dataProvider = InvoicePenjualan::getDataProvider(array(), $likeCriteria, 30);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionReport() {
		$this->active = "report";
		
		$reportForm = new ReportForm();
		
		if(isset($_POST['ReportForm'])) {
			$reportForm->attributes = $_POST['ReportForm'];
			
			$listInvoice = InvoicePenjualan::getInvoiceBetween(Utilities::formattedDateToTimestamp($reportForm->startTime), Utilities::formattedDateToTimestamp($reportForm->endTime), $reportForm->cabang);
			
			$transaction = $listInvoice->itemCount;
			$totalTransaction = 0;
			foreach($listInvoice->data as $invoice) {
				$totalTransaction += $invoice->getTotalPrice();
			}
			
			$this->render('report', array(
				'reportForm' => $reportForm,
				'invoices' => $listInvoice,
				'transaction' => $transaction,
				'totalTransaction' => $totalTransaction,
			));
		} else {
			$this->render('report', array(
				'reportForm' => $reportForm,
			));
		}
	}
	
	public function actionListToday() {
		$this->active = "today";
		
		$dataProvider = InvoicePenjualan::getInvoiceBetween(Utilities::getTodayTimeStamp(), time());
		
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InvoicePenjualan the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InvoicePenjualan::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InvoicePenjualan $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-penjualan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
