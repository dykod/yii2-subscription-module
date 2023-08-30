<?php

namespace common\modules\SubscriptionModule\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property string|null $event
 * @property string|null $recipient
 * @property int|null $is_block
 * @property int $created_at
 * @property int $updated_at
 */
class Subscription extends \yii\db\ActiveRecord
{
    const EVENT_REG = 'reg';
    const EVENT_LOGIN = 'login';
    const EVENT_VERIFY = 'verify';
    const EVENT_MESSAGE = 'message';
    const EVENT_LOGOUT = 'logout';

    public static function eventTypes()
    {
        return [
            self::EVENT_REG => 'Reg',
            self::EVENT_LOGIN => 'Login',
            self::EVENT_VERIFY => 'Verify',
            self::EVENT_MESSAGE => 'Message',
            self::EVENT_LOGOUT => 'Logout',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (strlen($this->created_at) == 16) {
                $this->setAttribute('created_at', $this->created_at . ':00');
            }
            if (strlen($this->updated_at) == 16) {
                $this->setAttribute('updated_at', $this->updated_at . ':00');
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['event', 'recipient'], 'required'],
            [['event'], 'string'],
            [['recipient'], 'email'],
            ['event', 'in', 'range' => array_keys(self::eventTypes())], // валидация для допустимых значений поля `event`
            [['is_block'], 'integer'],
            ['is_block', 'in', 'range' => [0, 1]],
            [['created_at', 'updated_at'], 'safe'],
            [['created_at', 'updated_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'recipient' => 'Recipient',
            'is_block' => 'Is Block',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
