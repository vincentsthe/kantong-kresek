<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $id
 * @property string $nama_barang
 * @property integer $jumlah_barang
 * @property integer $lokasi
 * @property integer $invoice_id
 * @property integer $harga_minimum
 * @property integer $harga_minimum_khusus
 *
 * The followings are the available model relations:
 * @property Cabang $lokasi0
 * @property InvoicePembelian $invoice
 */
class Inventory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inventory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_barang, jumlah_barang, invoice_id', 'required'),
			array('jumlah_barang, lokasi, invoice_id, harga_minimum, harga_minimum_khusus', 'numerical', 'integerOnly'=>true),
			array('nama_barang', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nama_barang, jumlah_barang, lokasi, invoice_id, harga_minimum, harga_minimum_khusus', 'safe', 'on'=>'search'),
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
			'lokasi0' => array(self::BELONGS_TO, 'Cabang', 'lokasi'),
			'invoice' => array(self::BELONGS_TO, 'InvoicePembelian', 'invoice_id'),
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
			'jumlah_barang' => 'Jumlah Barang',
			'lokasi' => 'Lokasi',
			'invoice_id' => 'Invoice',
			'harga_minimum' => 'Harga Minimum',
			'harga_minimum_khusus' => 'Harga Minimum Khusus',
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
		$criteria->compare('jumlah_barang',$this->jumlah_barang);
		$criteria->compare('lokasi',$this->lokasi);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('harga_minimum',$this->harga_minimum);
		$criteria->compare('harga_minimum_khusus',$this->harga_minimum_khusus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inventory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function deleteIfEmpty() {
		if($this->jumlah_barang == 0) {
			$this->delete();
		}
	}
}
