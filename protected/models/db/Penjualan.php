<?php

/**
 * This is the model class for table "penjualan".
 *
 * The followings are the available columns in table 'penjualan':
 * @property integer $id
 * @property string $nama_barang
 * @property integer $quantity
 * @property integer $harga
 * @property integer $harga_minimum
 * @property integer $harga_minimum_khusus
 * @property integer $harga_terjual
 * @property integer $invoice_id
 * @property integer $invoice_pembelian_id
 * @property string $serial_number
 *
 * The followings are the available model relations:
 * @property InvoicePenjualan $invoice
 * @property InvoicePembelian $invoidePembelian
 */
class Penjualan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjualan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_barang, quantity, harga, invoice_id', 'required'),
			array('quantity, harga, invoice_id', 'numerical', 'integerOnly'=>true),
			array('nama_barang', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nama_barang, quantity, harga, invoice_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'invoice' => array(self::BELONGS_TO, 'InvoicePenjualan', 'invoice_id'),
			'invoicePembelian' => array(self::BELONGS_TO, 'InvoicePembelian', 'invoice_pembelian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nama_barang' => 'Nama Barang',
			'quantity' => 'Quantity',
			'harga' => 'Harga',
			'invoice_id' => 'Invoice',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nama_barang',$this->nama_barang,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('harga',$this->harga);
		$criteria->compare('invoice_id',$this->invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Penjualan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getPenjualanByName($name, $withInvoice) {
		$criteria = new CDbCriteria;
		$criteria->addCondition('nama_barang="' . $name . '"');
	
		if($withInvoice) {
			return self::model()->with('invoice')->findAll($criteria);
		} else {
			return self::model()->findAll($criteria);
		}
	}
	
	public static function createRecord($inventory, $quantity, $harga, $invoice_id) {
		$penjualan = new Penjualan;
		$penjualan->nama_barang = $inventory->nama_barang;
		$penjualan->quantity = $quantity;
		$penjualan->harga = $inventory->harga;
		$penjualan->harga_minimum = $inventory->harga_minimum;
		$penjualan->harga_minimum_khusus = $inventory->harga_minimum_khusus;
		$penjualan->harga_terjual = $harga;
		$penjualan->invoice_id = $invoice_id;
		$penjualan->invoice_pembelian_id = $inventory->invoice_id;
		$penjualan->serial_number = $inventory->serial_number;
		
		$penjualan->save();
	}
}
