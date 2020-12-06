<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Сообщение',
                'value' => 'body',
            ],
            [
                'label' => 'Имя пользователя',
                'value' => function($model, $key, $index, $widget) {
                    return $model->user->username;
                }
            ]
        ],
    ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
