<?php

/**
 * This is the model class for table "invoice_penjualan".
 *
 * The followings are the available columns in table 'invoice_penjualan':
 * @property integer $id
 * @property string $nomor
 * @property string $nama_pembeli
 * @property string $alamat_pembeli
 * @property string $telpon_pembeli
 * @property string $nama_terkirim
 * @property string $alamat_terkirim
 * @property string $telpon_terkirim
 * @property string $comment_internal
 * @property string $comment_external
 * @property string $waktu_penerbitan
 * @property string $jenis_pembayaran
 * @property integer $down_payment
 * @property integer $biaya_pengiriman
 * @property integer $location
 * @property integer $batal
 *
 * The followings are the available model relations:
 * @property Cabang $location0
 * @property Penjualan[] $penjualans
 * @property TunggakanPembayaran $tunggakanPembayaran
 */
class InvoicePenjualan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoice_penjualan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_pembeli', 'required'),
			array('down_payment', 'numerical', 'integerOnly'=>true),
			array('nomor', 'length', 'max'=>127),
			array('biaya_pengiriman', 'length', 'max'=>10),
			array('biaya_pengiriman', 'numerical', 'integerOnly'=>true),
			array('nama_pembeli, telpon_pembeli, nama_terkirim, telpon_terkirim, jenis_pembayaran', 'length', 'max'=>64),
			array('alamat_pembeli, alamat_terkirim, comment_internal, comment_external', 'length', 'max'=>255),
			array('waktu_penerbitan', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nomor, nama_pembeli, alamat_pembeli, telpon_pembeli, nama_terkirim, alamat_terkirim, telpon_terkirim, comment_internal, comment_external, waktu_penerbitan, jenis_pembayaran, down_payment', 'safe', 'on'=>'search'),
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
			'location0' => array(self::BELONGS_TO, 'Cabang', 'location'),
			'penjualans' => array(self::HAS_MANY, 'Penjualan', 'invoice_id'),
			'tunggakanPembayaran' => array(self::HAS_ONE, 'TunggakanPembayaran', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nomor' => 'Nomor',
			'nama_pembeli' => 'Nama Pembeli',
			'alamat_pembeli' => 'Alamat Pembeli',
			'telpon_pembeli' => 'Telpon Pembeli',
			'nama_terkirim' => 'Nama Terkirim',
			'alamat_terkirim' => 'Alamat Terkirim',
			'telpon_terkirim' => 'Telpon Terkirim',
			'comment_internal' => 'Comment Internal',
			'comment_external' => 'Comment External',
			'waktu_penerbitan' => 'Waktu Penerbitan',
			'jenis_pembayaran' => 'Jenis Pembayaran',
			'down_payment' => 'Down Payment',
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
		$criteria->compare('nama_pembeli',$this->nama_pembeli,true);
		$criteria->compare('alamat_pembeli',$this->alamat_pembeli,true);
		$criteria->compare('telpon_pembeli',$this->telpon_pembeli,true);
		$criteria->compare('nama_terkirim',$this->nama_terkirim,true);
		$criteria->compare('alamat_terkirim',$this->alamat_terkirim,true);
		$criteria->compare('telpon_terkirim',$this->telpon_terkirim,true);
		$criteria->compare('comment_internal',$this->comment_internal,true);
		$criteria->compare('comment_external',$this->comment_external,true);
		$criteria->compare('waktu_penerbitan',$this->waktu_penerbitan,true);
		$criteria->compare('jenis_pembayaran',$this->jenis_pembayaran,true);
		$criteria->compare('down_payment',$this->down_payment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoicePenjualan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalPrice() {
		$totalPrice = $this->biaya_pengiriman;
		
		$listItem = $this->penjualans;
		foreach($listItem as $item) {
			$totalPrice += $item->harga_terjual * $item->quantity;
		}
		
		return $totalPrice;
	}
	
	public function beforeSave() {
		if($this->isNewRecord) {
			$this->waktu_penerbitan = time();
			$this->batal = 0;
			$this->nomor = Nomor::currentInvoicePenjualanNumber();
			Nomor::incrementInvoicePenjualanNumber();
		}
		
		return parent::beforeSave();
	}
}
