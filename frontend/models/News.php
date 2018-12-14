<?php

		namespace frontend\models;


        /**
         * This is the model class for table "posts".
         *
         * @property integer $idGroups
         * @property string $groupsName
         * @property integer $status
         * @property integer $created_at
         * @property integer $updated_at
         */

        class News extends \yii\db\ActiveRecord
        {

            const STATUS_PENDING=1;
            const STATUS_APPROVED=0;
            /**
             * @inheritdoc
             */
            public static function tableName()
            {
                return 'posts';
            }


            /**
             * @inheritdoc
             */
            public function attributeLabels()
            {
                return [
                    'id' => 'Id',
                    'title' => 'Название',
                    'is_release' => 'Статус',
                    'date' => 'Дата',
                    'date_update' => 'Обновлено',
                    'intro_text' => 'Превью текст',
                    'full_text' => 'Текст',
                    'hits' => 'Посещений',
                    'hide' => 'Публикация',
                ];
            }

        }
