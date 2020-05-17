<?php

namespace common\components;

/**
 * This custom GridView has it's pager class set to "common\components\LinkPager" by default.
 * See common\components\LinkPager for the reason
 * ************************************************************************************************************
 *
 * The GridView widget is used to display data in a grid.
 *
 * It provides features like [[sorter|sorting]], [[pager|paging]] and also [[filterModel|filtering]] the data.
 *
 * A basic usage looks like the following:
 *
 * ```php
 * <?= GridView::widget([
 *     'dataProvider' => $dataProvider,
 *     'columns' => [
 *         'id',
 *         'name',
 *         'created_at:datetime',
 *         // ...
 *     ],
 * ]) ?>
 * ```
 *
 * The columns of the grid table are configured in terms of [[Column]] classes,
 * which are configured via [[columns]].
 *
 * The look and feel of a grid view can be customized using the large amount of properties.
 *
 * For more details and usage information on GridView, see the [guide article on data widgets](guide:output-data-widgets).
 *
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @inheritdoc
     * @var array
     */
    public $pager = ['class' => 'common\components\LinkPager'];
}