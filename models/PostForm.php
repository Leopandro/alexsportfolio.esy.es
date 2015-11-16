<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 09.11.2015
 * Time: 11:03
 */
namespace app\models;
use Yii;
use yii\base\Model;

class PostForm extends Model
{
    public $text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['text', 'isLogged', 'message' => 'Необходимо авторизоваться', 'on' => 'default'],
            [['text'], 'required', 'message' => 'Заполните это поле'],
            ['text', 'string','min' => 6, 'tooShort' => 'Слишком короткое сообщение'],
        ];

    }
    public function isLogged($attribute)
    {
        if (!$this->hasErrors())
        {
        if (Yii::$app->user->isGuest)
                $this->addError($attribute, 'Необходимо авторизироваться');
        }

    }

    public function send()
    {
        $post = new Post;
        $post->user_id = Yii::$app->user->getId();
        $post->text = $this->text;
        $post->date = time();
        $post->save();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Текст сообщения',
        ];
    }
}
?>