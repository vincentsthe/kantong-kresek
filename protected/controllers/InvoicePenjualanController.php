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
				'actions'=>array('index', 'view', 'delete', 'create','update','createNew','preview','chooseItem','addItem','pembayaran','final','doCreate','print','removeItem','report','listToday','cancel'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','delete','createNew','preview','chooseItem','addItem','pembayaran','final','doCreate','print','removeItem','listToday','cancel'),
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
		
		foreach ($invoice->penjualans as $penjualan) {
			$inventory = new Inventory;
			
			$inventory->nama_barang = $penjualan->nama_barang;
			$inventory->lokasi = $invoice->location;
			$inventory->jumlah_barang = $penjualan->quantity;
			$inventory->invoice_id = $penjualan->invoice_pembelian_id;
			$inventory->harga = $penjualan->harga;
			$inventory->harga_minimum = $penjualan->harga_minimum;
			$inventory->harga_minimum_khusus = $penjualan->harga_minimum_khusus;
			$inventory->serial_number = $penjualan->serial_number;
			
			Inventory::tambah($inventory);
		}
		
		$invoice->batal = 1;
		$invoice->save();
		
		if(Yii::app()->user->roles == "admin") {
			$this->redirect(array("index"));
		} else {
			$this->redirect(array("listToday"));
		}
	}
	
	public function actionCreateNew() {
		$session = new CHttpSession;
		$session->open();
		
		$session['contact']=new PenjualanContactForm;
		$session['listPenjualan']=array();
		$session['pembayaran'] = new PembayaranPenjualanForm;
		
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
		
		if(!isset($session['contact'])) {
			$this->redirect(array('createNew'));
		}
		
		$model=new PenjualanContactForm;

		if(isset($_POST['PenjualanContactForm']))
		{
			$model->attributes=$_POST['PenjualanContactForm'];
			if($model->validate()) {
				$session['contact'] = $model;
				$this->redirect(array('preview'));
			} else {
				Yii::app()->user->setFlash('error', 'Input Tidak Valid.');
			}
		} else {
			$model->attributes = $session['contact']->getAttributes();
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
		
		if(!isset($session['contact'])) {
			$this->redirect(array('createNew'));
		}
		
		$this->render('preview', array(
			'contact'=>$session['contact'],
			'listPenjualan'=>$session['listPenjualan'],
		));
	}
	
	public function actionChooseItem() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['contact'])) {
			$this->redirect(array('createNew'));
		}
		
		$criteria = new CDbCriteria;
		$criteria->condition = "lokasi=" . Yii::app()->user->location;
		
		if(isset($_GET['filter'])) {
			$criteria->addCondition('nama_barang LIKE "%' . $_GET['filter'] . '%"');
		}
		
		$dataProvider = new CActiveDataProvider('Inventory', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize'=>20,
			),
		));
		
		$this->render('chooseItem', array(
			'dataProvider' => $dataProvider,
		));
	}
	
	public function actionAddItem($inventoryId) {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['contact'])) {
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
					
					$hargaMinimal = 0;
					if(Yii::app()->user->roles == "admin") {
						$hargaMinimal = $barang->harga_minimum_khusus;
					} else {
						$hargaMinimal = $barang->harga_minimum;
					}
					
					if ($hargaForm->harga >= $hargaMinimal) {
						$penjualan = new PenjualanBaru;
						$penjualan->nama_barang = $barang->nama_barang;
						$penjualan->quantity = $hargaForm->jumlah;
						$penjualan->harga = $barang->harga;
						$penjualan->harga_terjual = $hargaForm->harga;
						$penjualan->inventory_id = $inventoryId;
						$penjualan->serial_number = $barang->serial_number;
						
						$listPenjualan = $session['listPenjualan'];
						
						$index = -1;
						$i = 0;
						foreach($listPenjualan as $penjualanBaru) {
							if($penjualanBaru->inventory_id == $inventoryId) {
								$index = $i;
							}
							$i++;
						}
						
						if($index != -1) {
							unset($listPenjualan[$index]);
							$listPenjualan = array_values($listPenjualan);
						}
						
						$listPenjualan[] = $penjualan;
						$session['listPenjualan'] = $listPenjualan;
						
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
		
		if(!isset($session['contact'])) {
			$this->redirect(array('createNew'));
		}
		
		$listPenjualan = $session['listPenjualan'];
		
		$index = -1;
		$i = 0;
		foreach($listPenjualan as $penjualan) {
			if($penjualan->inventory_id == $inventory_id) {
				$index = $i;
			}
			$i++;
		}
		
		if($index != -1) {
			unset($listPenjualan[$index]);
			$listPenjualan = array_values($listPenjualan);
			
			Yii::app()->user->setFlash('success', 'Barang berhasil dihapus dari daftar.');
		}
		$session['listPenjualan'] = $listPenjualan;
		
		$this->redirect(array('preview'));
	}
	
	public function actionPembayaran() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['contact'])) {
			$this->redirect(array('createNew'));
		}
		
		$pembayaranForm = new PembayaranPenjualanForm;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='pembayaranPenjualan-form') {
			echo CActiveForm::validate($pembayaranForm);
			Yii::app()->end();
		}
		
		if(isset($_POST['PembayaranPenjualanForm'])) {
			$pembayaranForm->attributes = $_POST['PembayaranPenjualanForm'];
			
			if(strlen($pembayaranForm->biaya_pengiriman) == 0) {
				$pembayaranForm->biaya_pengiriman = 0;
			}
			
			if($pembayaranForm->validate()) {
				$session['pembayaran'] = $pembayaranForm;
				
				$this->redirect(array('final'));
			} else {
				Yii::app()->user->setFlash('error', "Input tidak valid.");
			}
		}
		
		if(isset($session['pembayaran'])) {
			$pembayaranForm = $session['pembayaran'];
		}
		
		$this->render('pembayaran', array(
			'contact' => $session['contact'],
			'listPenjualan' => $session['listPenjualan'],
			'pembayaranForm' => $pembayaranForm,
		));
	}
	
	public function actionFinal() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['contact']) || !isset($session['pembayaran'])) {
			$this->redirect(array('createNew'));
		}

		$invoice = new InvoicePenjualan;
		$invoice->nama_pembeli = $session['contact']->nama_pembeli;
		$invoice->alamat_pembeli = $session['contact']->alamat_pembeli;
		$invoice->telpon_pembeli = $session['contact']->telpon_pembeli;
		$invoice->nama_terkirim = $session['contact']->nama_terkirim;
		$invoice->alamat_terkirim = $session['contact']->alamat_terkirim;
		$invoice->telpon_terkirim = $session['contact']->telpon_terkirim;
		$invoice->comment_internal = $session['pembayaran']->comment_internal;
		$invoice->comment_external = $session['pembayaran']->comment_external;
		$invoice->jenis_pembayaran = $session['pembayaran']->jenis_pembayaran;
		$invoice->down_payment = $session['pembayaran']->down_payment;
		$invoice->biaya_pengiriman = $session['pembayaran']->biaya_pengiriman;
		$invoice->location = Yii::app()->user->location;
		
		$session['invoice'] = $invoice;
		
		$this->render('final', array(
			'invoice' => $session['invoice'],
			'listPenjualan' => $session['listPenjualan'],
		));
	}
	
	public function actionDoCreate() {
		$this->active = "create";
		
		$session = new CHttpSession;
		$session->open();
		
		if(!isset($session['contact']) || !isset($session['invoice'])) {
			$this->redirect(array('createNew'));
		}
		
		$invoice = $session['invoice'];
		
		if($invoice->save()) {
			$listPenjualan = $session['listPenjualan'];
			
			foreach($listPenjualan as $penjualanBaru) {
				$inventory = Inventory::model()->findByPk($penjualanBaru->inventory_id);
				
				$newPenjualan = new Penjualan;
				$newPenjualan->nama_barang = $penjualanBaru->nama_barang;
				$newPenjualan->quantity = $penjualanBaru->quantity;
				$newPenjualan->harga = $penjualanBaru->harga;
				$newPenjualan->harga_minimum = $inventory->harga_minimum;
				$newPenjualan->harga_minimum_khusus = $inventory->harga_minimum_khusus;
				$newPenjualan->harga_terjual = $penjualanBaru->harga_terjual;
				$newPenjualan->invoice_id = $invoice->id;
				$newPenjualan->invoice_pembelian_id = $inventory->invoice_id;
				$newPenjualan->serial_number = $penjualanBaru->serial_number;
				$newPenjualan->save();
				
				//deduct from inventory
				$criteria = new CDbCriteria;
				$inventory = Inventory::model()->findByPk($penjualanBaru->inventory_id);
				$inventory->jumlah_barang = $inventory->jumlah_barang - $newPenjualan->quantity;
				$inventory->save();
				$inventory->deleteIfEmpty();
				
				Tunggakan::createFromInvoice($invoice);
			}
		} else {
			throw new CHttpException(500, "Error");
		}
		
		$session->remove('invoice');
		$session->remove('contact');
		$session->remove('listPenjualan');
		$session->remove('pembayaran');
			
		Yii::app()->user->setFlash("success", "Invoice berhasil diterbitkan.");
		$this->redirect(array('print', "id"=>$invoice->id));
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
		
		$criteria = new CDbCriteria;
		
		if(isset($_GET['filter'])) {
			$criteria->condition = "nomor LIKE :filter OR nama_pembeli LIKE :filter OR nama_terkirim LIKE :filter";
			$criteria->params = array(':filter' => "%" . $_GET['filter'] . "%");
		}
		
		$dataProvider=new CActiveDataProvider('InvoicePenjualan', array(
			'criteria' => $criteria,
			'pagination' => array (
				'pageSize' => 20,
			),
			'sort'=>array(
				'defaultOrder'=>'id DESC',
				'attributes'=>array(
					'Waktu Penerbitan'=>array(
						'asc'=>'waktu_penerbitan',
						'desc'=>'waktu_penerbitan DESC',
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
			
			if($reportForm->cabang != 0) {
				$criteria->addCondition('(location=' . $reportForm->cabang . ')');
			}
			$criteria->addCondition('(waktu_penerbitan >= ' . Utilities::formattedDateToTimestamp($reportForm->startTime) . ')');
			$criteria->addCondition('(waktu_penerbitan <= ' . Utilities::formattedDateToTimestamp($reportForm->endTime) . ')');
			
			$listInvoice = new CActiveDataProvider('InvoicePenjualan', array(
				'criteria'=>$criteria,
				'pagination'=> array(
					'pageSize'=>20,
				),
				'sort'=>array(
						'defaultOrder'=>'id DESC',
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
			'invoice' => $invoice,
		));
	}
	
	public function actionListToday() {
		$this->active = "today";
		
		$criteria = new CDbCriteria;
		$criteria->condition = "waktu_penerbitan>" . Utilities::getTodayTimeStamp();
		
		$dataProvider=new CActiveDataProvider('InvoicePenjualan', array(
				'criteria' => $criteria,
				'pagination' => array (
						'pageSize' => 20,
				),
				'sort'=>array(
						'defaultOrder'=>'id DESC',
						'attributes'=>array(
								'Waktu Penerbitan'=>array(
										'asc'=>'waktu_penerbitan',
										'desc'=>'waktu_penerbitan DESC',
								),
								'*',
						),
				),
		));
		
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
