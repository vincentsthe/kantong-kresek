<?php

/**
 * This is the model class for table "invoice_pembelian".
 *
 * The followings are the available columns in table 'invoice_pembelian':
 * @property integer $id
 * @property string $nomor
 * @property string $nama_supplier
 * @property string $waktu_penerbitan
 * @property string $jatuh_tempo_pembayaran
 * @property string $comment_internal
 * @property string $comment_external
 * @property integer $biaya_pengiriman
 *
 * The followings are the available model relations:
 * @property Inventory[] $inventories
 * @property Pembelian[] $pembelians
 */
class InvoicePembelian extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoice_pembelian';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor, comment_internal, comment_external', 'length', 'max'=>255),
			array('nama_supplier', 'length', 'max'=>127),
			array('biaya_pengiriman', 'length', 'max'=>10),
			array('biaya_pengiriman', 'numerical', 'integerOnly'=>true),
			array('waktu_penerbitan, jatuh_tempo_pembayaran', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nomor, nama_supplier, waktu_penerbitan, jatuh_tempo_pembayaran, comment_internal, comment_external', 'safe', 'on'=>'search'),
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
			'inventories' => array(self::HAS_MANY, 'Inventory', 'invoice_id'),
			'pembelians' => array(self::HAS_MANY, 'Pembelian', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nomor' => 'Nomor Invoice',
			'nama_supplier' => 'Nama Supplier',
			'waktu_penerbitan' => 'Waktu Penerbitan',
			'jatuh_tempo_pembayaran' => 'Jatuh Tempo Pembayaran',
			'comment_internal' => 'Comment Internal',
			'comment_external' => 'Comment External',
			'biaya_pengiriman' => 'Biaya Pengiriman',
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
		$criteria->compare('nomor',$this->nomor,true);
		$criteria->compare('nama_supplier',$this->nama_supplier,true);
		$criteria->compare('waktu_penerbitan',$this->waktu_penerbitan,true);
		$criteria->compare('jatuh_tempo_pembayaran',$this->jatuh_tempo_pembayaran,true);
		$criteria->compare('comment_internal',$this->comment_internal,true);
		$criteria->compare('comment_external',$this->comment_external,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoicePembelian the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalPrice() {
		$totalPrice = $this->biaya_pengiriman;
		
		$listItem = $this->pembelians;
		foreach($listItem as $item) {
			$totalPrice += $item->harga * $item->quantity;
		}
		
		return $totalPrice;
	}
	
	public function beforeSave() {
		if($this->isNewRecord) {
			$this->nomor = Nomor::currentInvoicePembelianNumber();
			$this->waktu_penerbitan = time();
			if($this->jatuh_tempo_pembayaran <= 0) {
				$this->jatuh_tempo_pembayaran = time();
			}
			Nomor::incrementInvoicePembelianNumber();
		}
		
		return parent::beforeSave();
	}
}
