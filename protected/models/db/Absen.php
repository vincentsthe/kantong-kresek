<?php
Yii::import('ext.Utilities');

/**
 * This is the model class for table "absen".
 *
 * The followings are the available columns in table 'absen':
 * @property integer $id
 * @property integer $user_id
 * @property integer $timestamp
 * @Property integer $type
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Absen extends CActiveRecord
{
	public static $TYPE_DATANG = 0;
	public static $TYPE_PULANG = 1;
	
	public static function createAbsen($userId, $timeStamp, $type) {
		$instance = new Absen;
		
		$instance->user_id = $userId;
		$instance->timestamp = $timeStamp;
		$instance->type = $type;
		
		$instance->save();
		
		return $instance;
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'absen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, timestamp, type', 'required'),
			array('user_id, timestamp', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, timestamp', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('timestamp',$this->timestamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Absen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getAllTodayAbsenByUser($user) {
		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id=' . $user->id);
		$criteria->addCondition('timestamp>=' . Utilities::getTodayTimeStamp());
		
		return self::model()->findAll($criteria);
	}
	
	public function updateTimestamp($timeStamp) {
		$this->timestamp = $timeStamp;
		$this->save();
	}
	
	public static function getAbsenMasuk($time) {
		$startTime = Utilities::beginDay($time);
		$endTime = $startTime + (24 * 60 * 60);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "type=" . Absen::$TYPE_DATANG . " AND timestamp>=" . $startTime . " AND timestamp<" . $endTime;
		
		return new CActiveDataProvider('Absen', array(
				'criteria' => $criteria,
			));
	}
	
	public static function getAbsenPulang($time) {
		$startTime = Utilities::beginDay($time);
		$endTime = $startTime + (24 * 60 * 60);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "type=" . Absen::$TYPE_PULANG . " AND timestamp>=" . $startTime . " AND timestamp<" . $endTime;
		
		return new CActiveDataProvider('Absen', array(
				'criteria' => $criteria,
			));
	}
}
