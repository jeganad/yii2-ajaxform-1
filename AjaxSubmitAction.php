<?php
/**
 * @link https://github.com/jwaldock/yii2-ajaxform/
 * @copyright Copyright (c) 2016 Joel Waldock
 */

namespace jwaldock\ajaxform;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * AjaxSubmitAction is an external [[Action]] that saves a model from [[\yii\widgets\ActiveForm]] 
 * data submitted by AJAX.
 * 
 * AjaxSubmitAction is intended to be used with [[AjaxFormWidget]] to provide AJAX model submission
 * for [[\yii\widgets\ActiveForm]].
 * 
 * This action can be set up in a [[Controller]] like the following:
 * 
 * ```php
 * public function actions()
 * {
 *      return [
 *          'submit-model' => [
 *              'class' => 'jwaldock\ajaxform\AjaxSubmitAction',
 *              'modelClass' => 'model', // the fully qualified class name of the model  
 *              'tabular' => true, // set to true if using a tabular form - defaults to false
 *              'scenario' => 'model-scenario' // optional model scenario
 *          ],
 *          // other actions
 *      ];
 * }
 * ```
 * 
 * @author Joel Waldock <joel.c.waldock@gmail.com>
 */
class AjaxSubmitAction extends BaseAjaxAction
{    
    /**
     * @inheritDoc
     */
    protected function runTabular($models)
    {
        if ($success = Model::validateMultiple($models)) {
            foreach ($models as $model) {
                $model->save(false);
            }
        }
        return [
            'success' => $success,
            'modeldata' => ArrayHelper::toArray($models),
        ];
    }
    
    /**
     * @inheritDoc
     */
    protected function runSingle($model)
    {
        return [
            'success' => $model->save(),
            'modeldata' => $model->toArray(),
        ];
    }
}
