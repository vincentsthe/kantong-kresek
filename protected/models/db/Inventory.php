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
 * @property integer $harga
 * @property integer $harga_minimum
 * @property integer $harga_minimum_khusus
 * @property string  $serial_number
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
	
	public function duplicate() {
		$inventory = new Inventory;
		
		$inventory->nama_barang = $this->nama_barang;
		$inventory->jumlah_barang = 0;
		$inventory->lokasi = $this->lokasi;
		$inventory->invoice_id = $this->invoice_id;
		$inventory->harga = $this->harga;
		$inventory->harga_minimum = $this->harga_minimum;
		$inventory->harga_minimum_khusus = $this->harga_minimum_khusus;
		$inventory->serial_number = $this->serial_number;
		
		return $inventory;
	}
	
	public function searchInLocation($location) {
		$criteria = new CDbCriteria;
		$criteria->addCondition('nama_barang="' . $this->nama_barang . '"');
		$criteria->addCondition('invoice_id=' . $this->invoice_id);
		$criteria->addCondition('serial_number="' . $this->serial_number . '"');
		$criteria->addCondition('lokasi=' . $location->id);
		
		$inventory = self::model()->find($criteria);
		
		if($inventory != null) {
			return $inventory;
		} else {
			$inventory = $this->duplicate();
			$inventory->lokasi = $location->id;
			
			return $inventory;
		}
	}
	
	public static function tambah($barang) {
		$criteria = new CDbCriteria;
		$criteria->condition = "nama_barang=:nama_barang AND invoice_id=:invoice_id AND lokasi=:lokasi AND serial_number=:serial_number";
		$criteria->params = array(
									":nama_barang"=>$barang->nama_barang,
									":invoice_id"=>$barang->invoice_id,
									":lokasi"=>$barang->lokasi,
									":serial_number"=>$barang->serial_number,
							);
		
		$initialInventory = self::model()->find($criteria);
		
		if ($initialInventory == null) {
			$inventory = new Inventory;
			$inventory->nama_barang = $barang->nama_barang;
			$inventory->jumlah_barang = $barang->jumlah_barang;
			$inventory->invoice_id = $barang->invoice_id;
			$inventory->lokasi = $barang->lokasi;
			$inventory->harga = $barang->harga;
			$inventory->harga_minimum = $barang->harga_minimum;
			$inventory->harga_minimum_khusus = $barang->harga_minimum_khusus;
			$inventory->serial_number = $barang->serial_number;
			$inventory->save();
		} else {
			$initialInventory->jumlah_barang = $initialInventory->jumlah_barang + $barang->jumlah_barang;
			$initialInventory->harga = $barang->harga;
			$initialInventory->harga_minimum = $barang->harga_minimum;
			$initialInventory->harga_minimum_khusus = $barang->harga_minimum_khusus;
			$initialInventory->save();
		}
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
	
	public function beforeSave() {
		if(($this->serial_number == null) || (ctype_space($this->serial_number))) {
			$this->serial_number = "";
		}
		
		return parent::beforeSave();
	}
	
	public function subtract($count) {
		$this->jumlah_barang = $this->jumlah_barang - $count;
		$this->save();
		$this->deleteIfEmpty();
	}
	
	public function add($count) {
		$this->jumlah_barang = $this->jumlah_barang + $count;
		$this->save();
	}
	
	public function setLocation($location) {
		$this->lokasi = $location->id;
		$this->save();
	}
	
	public function deleteIfEmpty() {
		if($this->jumlah_barang == 0) {
			$this->delete();
		}
	}
}
