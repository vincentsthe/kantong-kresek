<?php

Yii::import('ext.Utilities');

class InvoicePembelianController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/invoicePembelianLayout';
	
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
				'actions'=>array('index', 'view', 'delete', 'create','update', 'addItem', 'preview', 'doCreate', 'print', 'removeItem', 'report'),
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
		
		$model=new InvoicePembelian;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['InvoicePembelian']))
		{
			$model->attributes=$_POST['InvoicePembelian'];

			if($model->biaya_pengiriman == null) {
				$model->biaya_pengiriman = 0;
			}
			
			if($model->validate()) {
				$session = new CHttpSession;
				$session->open();
				$session['invoicePembelian'] = $model;
				$session['listPembelian'] = array();
				return Self::actionPreview();
			} else {
				Yii::app()->user->setFlash('error', 'Input tidak valid.');
			}
			//$this->redirect(array('preview', 'invoicePreview'=>$model, 'listItem'=>array()));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionPreview() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['invoicePembelian']) || !isset($session['listPembelian'])) {
			$this->redirect(array('create'));
		}
		
		$listPembelian = $session['listPembelian'];
		
		if(isset($_POST['Pembelian'])) {
			$pembelian = new Pembelian;
			$pembelian->attributes = $_POST['Pembelian'];
			
			if($pembelian->validate()) {
				$listPembelian[] = $pembelian;
				$session['listPembelian'] = $listPembelian;
				Yii::app()->user->setFlash('success', 'Barang berhasil ditambahkan.');
			} else {
				Yii::app()->user->setFlash('error', 'Masukan tidak valid, ulangi masukan!');
			}
		}
		
		$this->render('preview', array(
			'invoice'=>$session['invoicePembelian'],
			'listItem'=>$listPembelian,
		));
	}
	
	public function actionAddItem() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['invoicePembelian']) || !isset($session['listPembelian'])) {
			$this->redirect(array('create'));
		}
		
		$model = new Pembelian;
		
		$this->render('addItem', array(
				'model'=>$model
		));
		
	}
	
	public function actionRemoveItem($index) {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['invoicePembelian']) || !isset($session['listPembelian'])) {
			$this->redirect(array('create'));
		}
		
		$listPembelian = $session['listPembelian'];
		unset($listPembelian[$index]);
		$listPembelian = array_values($listPembelian);
		
		$session['listPembelian'] = $listPembelian;
		Yii::app()->user->setFlash('success', 'Barang berhasil dihapus dari daftar');
		
		$this->redirect(array('preview'));
	}
	
	public function actionDoCreate() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['invoicePembelian']) || !isset($session['listPembelian'])) {
			$this->redirect(array('create'));
		}
		
		$invoice = $session['invoicePembelian'];
		$invoice->jatuh_tempo_pembayaran = Utilities::formattedDateToTimestamp($invoice->jatuh_tempo_pembayaran);
		$invoice->save();
		
		$listItem = $session['listPembelian'];
		foreach($listItem as $item) {
			$pembelian = new Pembelian;
			$pembelian = $item;
			$pembelian->invoice_id = $invoice->id;
			$pembelian->save();
			
			//create inventory
			$inventory = new Inventory;
			$inventory->nama_barang = $pembelian->nama_barang;
			$inventory->jumlah_barang = $pembelian->quantity;
			$inventory->invoice_id = $pembelian->invoice_id;
			$inventory->save();
		}
		
		//remove session
		$session->remove('invoicePembelian');
		$session->remove('listPembelian');
		
		Yii::app()->user->setFlash('success', 'Invoice berhasil diterbitkan.');
		$this->redirect(array('view', 'id' => $invoice->id));
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

		if(isset($_POST['InvoicePembelian']))
		{
			$model->attributes=$_POST['InvoicePembelian'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'User berhasil diedit.');
				$this->redirect(array('view','id'=>$model->id));
			} else {
				Yii::app()->user->setFlash('error', 'Input tidak valid.');
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
		
		$criteria = new CDbCriteria;
		
		if(isset($_GET['filter'])) {
			$criteria->condition = "nama_supplier LIKE :filter";
			$criteria->params = array(':filter' => "%" . $_GET['filter'] . "%");
		}
		
		$dataProvider=new CActiveDataProvider('InvoicePembelian', array(
			'criteria' => $criteria,
			'pagination' => array (
				'pageSize' => 20,
			),
			'sort'=>array(
				'attributes'=>array(
					'Waktu Penerbitan'=>array(
						'asc'=>'waktu_penerbitan',
						'desc'=>'waktu_penerbitan DESC',
					),
					'Jatuh Tempo Pembayaran'=>array(
						'asc'=>'jatuh_tempo_pembayaran',
						'desc'=>'jatuh_tempo_pembayaran DESC',
					),
					'*',
				),
			),
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionReport() {
		$this->active = "report";
	
		$reportForm = new ReportForm;
		$reportForm->cabang = 0;
		$reportForm->startTime = Utilities::timestampToFormattedDate(time());
		$reportForm->endTime = Utilities::timestampToFormattedDate(time());
	
		if(isset($_POST['ReportForm'])) {
			$reportForm->attributes = $_POST['ReportForm'];
				
			$criteria = new CDbCriteria;
			
			$criteria->addCondition('(waktu_penerbitan >= ' . Utilities::formattedDateToTimestamp($reportForm->startTime) . ')');
			$criteria->addCondition('(waktu_penerbitan <= ' . Utilities::formattedDateToTimestamp($reportForm->endTime) . ')');
				
			$listInvoice = new CActiveDataProvider('InvoicePembelian', array(
					'criteria'=>$criteria,
					'pagination'=> array(
							'pageSize'=>20,
					),
					'sort'=>array(
							'attributes'=>array(
									'Waktu Transaksi'=>array(
											'asc'=>'waktu_penerbitan',
											'desc'=>'waktu_penerbitan DESC',
									),
									'*',
							),
					),
			));
				
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
	
	public function actionPrint($id) {
		$this->active = "view";
		$this->layout = '//layouts/plain';
		
		$invoice = $this->loadModel($id);
		
		$this->render('print', array(
				'model' => $invoice,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InvoicePembelian the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InvoicePembelian::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InvoicePembelian $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-pembelian-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
