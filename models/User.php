<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $image
 * @property int $status
 *
 * @property Opinion[] $opinions
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['email'],'email'],
            [['login', 'password', 'name', 'image','auth_token','last_name'], 'string', 'max' => 255],
            [['login', 'password'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'image' => 'Image',
            'status' => 'Status',
            'auth_token'=> 'Auth Token'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::className(), ['user_id' => 'id']);
    }

    public function getPages()
    {
        return $this->hasMany(User::className(), ['user_id' => 'id']);
    }

    public function saveImage($file){
        $this->image = $file;
        return $this->save(false);
    }

    public function deleteImage(){
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteFileImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();


        $models = Page::find()->where(['user_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }

        $models = Lay::find()->where(['user_id'=>$this->id])->all();
        foreach ($models as $model){
            $model->delete();
        }

        return parent::beforeDelete();
    }


    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);// TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id; // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_token; // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_token===$authKey;// TODO: Implement validateAuthKey() method.
    }

    public static function findByUsername($login){
        return self::findOne(['login'=>$login]);
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    public static function getAvatar($id){
        $user = self::findOne(['id'=> $id]);
        if (empty($user->image)){
            return "/upload/noimage/noavat.jpg";
        }
        return "/".$user->image;
    }

    public static function getLogin($id){
        return self::findOne(['id'=> $id])->login;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_token = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }


}
