<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property string $author
 * @property string $email
 * @property string $url
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property Post $post
 */
class Comment extends CActiveRecord
{
    const STATUS_PENDING=1;
    const STATUS_APPROVED=2;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
           array('content, author, email', 'required'),
           array('author, email, url', 'length' ,'max'=>128),
           array('email', 'email'),
           array('url', 'url'),
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
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Comment',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'author' => 'Name',
            'email' => 'Email',
            'url' => 'Website',
            'post_id' => 'Post',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('author', $this->author, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('post_id', $this->post_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    /*
    we want to record the creation time of a comment, 
    we override the beforeSave() method of Comment like we do for the Post model:
    */
    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->IsNewRecord) {
                $this->create_time=time();
            }
            return true;
        } else {
            return false;
        }
    }
    /*
    add from Topic "Managing Comments"
    */
    public function approve()
    {
        $this->status=Comment::STATUS_APPROVED;
        $this->update(array('status'));
    }
    /*
    According to http://www.yiiframework.com/doc/blog/1.1/en/portlet.menu#c8515
    */
    public function getPendingCommentCount()
    {
        return $this->count('status='.self::STATUS_PENDING);
    }
    /*
    add from "Creating Recent Comments Portlet"
    */
    public function findRecentComments($limit = 10)
    {
        return $this->with('post')->findAll(array(
            'condition'=>'t.status='.self::STATUS_APPROVED,
            'order'=>'t.create_time DESC',
            'limit'=>$limit,
        ));
    }
    /**
     * @return string the hyperLink display for the current comment's author
     * Add from yii\demos\blog\protected\models\Comment
    */
    public function getAuthorLink()
    {
        if (!empty($this->url)) {
            return CHtml::link(CHtml::encode($this->author), $this->url);
        } else {
            return CHtml::encode($this->author);
        }
    }
    /**
     * Refernce http://www.yiiframework.com/forum/index.php/topic/71069-comment-and-its-behaviors-do-not-have-a-method-or-closure-named-geturl/
    */
    public function getUrl($post = null)
    {
        return Yii::app()->createUrl('post/view', array(
            'id' =>$this->id,
            'title' =>$this->post->title,
         ));
    }
}
