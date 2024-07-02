<?php

namespace app\records;

use Yii;

/**
 * This is the model class for table "visitor".
 *
 * @property int $id
 * @property string $ip
 * @property string $user_agent
 * @property string $language
 * @property string $os
 * @property string $browser
 * @property string $device
 * @property string $created_at
 * @property string $updated_at
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['ip', 'os', 'browser', 'device'], 'string', 'max' => 45],
            [['user_agent'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
            'language' => 'Language',
            'os' => 'Os',
            'browser' => 'Browser',
            'device' => 'Device',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
