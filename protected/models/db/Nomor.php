<?php

/**
 * This is the model class for table "nomor".
 *
 * The followings are the available columns in table 'nomor':
 * @property integer $id
 * @property string $tipe
 * @property string $nomor
 */
class Nomor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nomor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipe, nomor', 'required'),
			array('tipe, nomor', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipe, nomor', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipe' => 'Tipe',
			'nomor' => 'Nomor',
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
		$criteria->compare('tipe',$this->tipe,true);
		$criteria->compare('nomor',$this->nomor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nomor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function currentInvoicePenjualanNumber() {
		$criteria = new CDbCriteria;
		$criteria->condition = "tipe='invoice_penjualan'";
		
		return self::model()->find($criteria)->nomor;
	}
	
	public static function incrementInvoicePenjualanNumber() {
		$criteria = new CDbCriteria;
		$criteria->condition = "tipe='invoice_penjualan'";
		
		$oldRecord = self::model()->find($criteria);
		$oldNomor = $oldRecord->nomor;
		
		$headerChar = substr($oldNomor, 3, 1);
		$angka = (int)substr($oldNomor, 4, 5);
		
		$angka++;
		if($angka >= 100000) {
			$angka = 1;
			$headerChar = chr(ord($headerChar) + 1);
		}
		
		$oldRecord->nomor = substr($oldNomor, 0, 3) . $headerChar . sprintf("%05d", $angka);
		$oldRecord->save(); 
	}
	
	public static function currentInvoicePembelianNumber() {
		$criteria = new CDbCriteria;
		$criteria->condition = "tipe='invoice_pembelian'";
		
		return self::model()->find($criteria)->nomor;
	}
	
	public static function incrementInvoicePembelianNumber() {
		$criteria = new CDbCriteria;
		$criteria->condition = "tipe='invoice_pembelian'";
		
		$oldRecord = self::model()->find($criteria);
		$oldNomor = $oldRecord->nomor;
		
		$headerChar = substr($oldNomor, 3, 1);
		$angka = (int)substr($oldNomor, 4, 5);
		
		$angka++;
		if($angka >= 100000) {
			$angka = 1;
			$headerChar = chr(ord($headerChar) + 1);
		}
		
		$oldRecord->nomor = substr($oldNomor, 0, 3) . $headerChar . sprintf("%05d", $angka);
		$oldRecord->save();
	}
}
