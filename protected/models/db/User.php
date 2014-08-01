<?php

Yii::import('ext.Utilities');

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $fullname
 * @property string $role
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, fullname', 'required'),
			array('username, password, fullname', 'length', 'max'=>127),
			array('role', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, fullname, role', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'fullname' => 'Fullname',
			'role' => 'Role',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getAllUser() {
		return self::model()->findAll();
	}
	
	public static function getUserById($id) {
		$user = self::model()->findByPk($id);
		
		if($user == null) {
			throw new CHttpException("404", "User ID not valid");
		} else {
			return $user;
		}
	}
	
	public static function getUserByUsername($username) {
		$criteria = new CDbCriteria;
		$criteria->condition = "username='" . $username . "'";
		
		$user = self::model()->find($criteria);
		
		if($user == null) {
			throw new CHttpException("404", "username not found");
		} else {
			return $user;
		}
	}
	
	public static function findAllUser() {
		$allUser = self::getAllUser();
		
		$returnArray = array();
		
		foreach($allUser as $user) {
			$returnArray[$user->id] = $user->username;
		}
		
		return $returnArray;
	}
	
	public function validatePassword($password) {
		return $this->password == Utilities::hashPassword($password);
	}
	
	public function beforeSave() {
		if($this->isNewRecord) {
			$this->password = Utilities::hashPassword($this->password);
		}
		
		return parent::beforeSave();
	}
	
	public static function usernameExist($username) {
		$criteria = new CDbCriteria;
		$criteria->condition = "username='" . $username . "'";
		
		return (User::model()->find($criteria) != null);
	}
}
