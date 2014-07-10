<?php

/**
 * This is the model class for table "tunggakan".
 *
 * The followings are the available columns in table 'tunggakan':
 * @property integer $id
 * @property integer $jumlah
 * @property integer $invoice_id
 * @property integer $nama
 *
 * The followings are the available model relations:
 * @property InvoicePenjualan $invoice
 */
class Tunggakan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tunggakan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jumlah, invoice_id', 'required'),
			array('jumlah, invoice_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, jumlah, invoice_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'jumlah' => 'Jumlah',
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
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('invoice_id',$this->invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tunggakan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function createFromInvoice($invoice) {
		$besar = $invoice->getTotalPrice() - $invoice->down_payment;
		
		if($besar != 0) {
			$tunggakan = new Tunggakan;
			$tunggakan->jumlah = $besar;
			$tunggakan->invoice_id = $invoice->id;
			$tunggakan->nama = $invoice->nama_pembeli;
			
			$tunggakan->save();
		}
	}
	
	public function bayar($besar) {
		$this->jumlah = $this->jumlah - $besar;
		
		$this->save();
		
		$this->deleteIfEven();
	}
	
	public function deleteIfEven() {
		if($this->jumlah <= 0) {
			$this->delete();
		}
	}
}
