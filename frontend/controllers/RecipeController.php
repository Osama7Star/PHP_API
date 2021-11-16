<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Recipe;
use frontend\models\RecipeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\Model;
use frontend\models\Model1;
use frontend\models\RecipeStep;
use frontend\models\RecipeStepIngredient;
use frontend\models\RecipeStepInstruction;
use yii\web\UploadedFile;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Recipe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Recipe model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelRecipe = new Recipe;
        $modelsRecipeStep = [new RecipeStep];
        $modelsStepIngredient = [[new RecipeStepIngredient]];
        $modelsStepInstruction = [[new RecipeStepInstruction]];

        if ($modelRecipe->load(Yii::$app->request->post())) {

            $modelsRecipeStep = Model::createMultiple(RecipeStep::classname());
            Model::loadMultiple($modelsRecipeStep, Yii::$app->request->post());

            // validate recipe and steps models
            $valid = $modelRecipe->validate();
            $valid = Model::validateMultiple($modelsRecipeStep) && $valid;             
            
            if (isset($_POST['RecipeStepIngredient'][0][0])) {
                foreach ($_POST['RecipeStepIngredient'] as $indexRecipeStep => $stepingredients) {
                    foreach ($stepingredients as $indexStepIngredient => $stepingredient) {
                        $data['RecipeStepIngredient'] = $stepingredient;
                        $modelStepIngredient = new RecipeStepIngredient;
                        $modelStepIngredient->load($data);
                        $modelsStepIngredient[$indexRecipeStep][$indexStepIngredient] = $modelStepIngredient;
                        $valid = $modelStepIngredient->validate();
                    }
                }
            }
            
            if (isset($_POST['RecipeStepInstruction'][0][0])) {
                foreach ($_POST['RecipeStepInstruction'] as $indexRecipeStep => $stepinstructions) {
                    foreach ($stepinstructions as $indexStepInstruction => $stepinstruction) {                        
                        $data['RecipeStepInstruction'] = $stepinstruction;                        
                        $modelStepInstruction = new RecipeStepInstruction;
                        $modelStepInstruction->load($data);
                        $modelsStepInstruction[$indexRecipeStep][$indexStepInstruction] = $modelStepInstruction;
                        $valid = $modelStepInstruction->validate();                        
                    }
                }
            }
            
           
            

            if ($valid) {
                
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    
                    $recipeimageName = $modelRecipe->e_name;
                    $modelRecipe->file = UploadedFile::getInstance($modelRecipe,'file');
                                        
                    if($modelRecipe->file){
                        //Set the path that the file will be uploaded to
                        $path = Yii::getAlias('@api') .'/web/uploads/recipes/';
                        $modelRecipe->file->saveAs($path.$recipeimageName.'.'.$modelRecipe->file->extension);
                        $modelRecipe->image = 'uploads/'.$recipeimageName.'.'.$modelRecipe->file->extension;
                    }
                    
                    if ($flag = $modelRecipe->save(false)) {
                        foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {

                            if ($flag === false) {
                                break;
                            }
                            
                            
//                            print_r($modelRecipeStep);
//                            print_r($modelRecipeStep->file);
//                            print_r($modelRecipeStep->image);
//                            die;
                            
//                            $recipestepimage = $modelRecipe->e_name;
//                            $modelRecipeStep->file = UploadedFile::getInstances($modelRecipeStep,'file');
//                            
//                            //Set the path that the file will be uploaded to
//                            $path = Yii::getAlias('@api') .'/web/uploads/steps/';
//                            $modelRecipeStep->file->saveAs($path.$recipestepimage.'.'.$modelRecipeStep->file->extension);
//                            $modelRecipeStep->image = 'uploads/'.$recipestepimage.'.'.$modelRecipeStep->file->extension;
//
                            $modelRecipeStep->recipe_id = $modelRecipe->recipe_id;
                              
//                            $modelRecipeStep->save();
                            if (!($flag = $modelRecipeStep->save(false))) {
                                break;
                            }

                            if (isset($modelsStepIngredient[$indexRecipeStep]) && is_array($modelsStepIngredient[$indexRecipeStep])) {
                                foreach ($modelsStepIngredient[$indexRecipeStep] as $indexStepIngredient => $modelStepIngredient) {
                                    if(!empty($modelStepIngredient->ingredient_id) && !empty($modelStepIngredient->amount)&& !empty($modelStepIngredient->measure_unit)){ 
                                    $modelStepIngredient->recipe_step_id = $modelRecipeStep->recipe_step_id;
                                        if (!($flag = $modelStepIngredient->save(false))) {
                                            break;
                                        }
                                    }
//                                    else{
//                                        $modelStepIngredient->recipe_step_id = $modelRecipeStep->recipe_step_id;
//                                        $modelStepIngredient->ingredient_id = 1;
//                                        $modelStepIngredient->amount = 0;
//                                        $modelStepIngredient->measure_unit = '0';
//                                        $modelStepIngredient->save();
//                                        break;
//                                    }
                                }
                            }
                            
                            if (isset($modelsStepInstruction[$indexRecipeStep]) && is_array($modelsStepInstruction[$indexRecipeStep])) {
                                foreach ($modelsStepInstruction[$indexRecipeStep] as $indexStepInstruction => $modelStepInstruction) {
                                    $modelStepInstruction->recipe_step_id = $modelRecipeStep->recipe_step_id;
                                        if (!($flag = $modelStepInstruction->save(false))) {
                                            break;
                                        }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelRecipe->recipe_id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }else{
                echo 'nor valid';
                die;
            }
        }

        return $this->render('create', [
            'modelRecipe' => $modelRecipe,
            'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
            'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,
            'modelsStepInstruction' => (empty($modelsStepInstruction)) ? [[new RecipeStepInstruction]] : $modelsStepInstruction,
        ]);
    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelRecipe = $this->findModel($id);
//        print_r($modelRecipe);
//        die;
        $modelsRecipeStep = $modelRecipe->recipeSteps;
//        var_dump($modelsRecipeStep);
//        die;
        $modelsStepIngredient = [];
        $oldStepIngridents = [];
        $modelsStepInstruction = [];
        $oldStepInstructions = [];

        if (!empty($modelsRecipeStep)) {
            foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {
                $stepingredients = $modelRecipeStep->recipeStepIngredients;
                $modelsStepIngredient[$indexRecipeStep] = $stepingredients;
                $oldStepIngridents = ArrayHelper::merge(ArrayHelper::index($stepingredients, 'recipe_step_ingredient_id'), $oldStepIngridents);
            }
            
            foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {
                $stepinstructions = $modelRecipeStep->recipeStepInstructions;
                $modelsStepInstruction[$indexRecipeStep] = $stepinstructions;
                $oldStepInstructions = ArrayHelper::merge(ArrayHelper::index($stepinstructions, 'recipe_step_instruction_id'), $oldStepInstructions);
            }
        }

        if ($modelRecipe->load(Yii::$app->request->post())) {

            // reset
            $modelsStepIngredient = [];
            
            // reset
            $modelsStepInstruction = [];
            

            $oldRecipeStepIDs = ArrayHelper::map($modelsRecipeStep, 'recipe_step_id', 'recipe_step_id');
            $modelsRecipeStep = Model1::createMultiple(RecipeStep::classname(), $modelsRecipeStep);
            Model::loadMultiple($modelsRecipeStep, Yii::$app->request->post());
            $deletedRecipeStepIDs = array_diff($oldRecipeStepIDs, array_filter(ArrayHelper::map($modelsRecipeStep, 'recipe_step_id', 'recipe_step_id')));

            // validate person and houses models
            $valid = $modelRecipe->validate();
            $valid = Model::validateMultiple($modelsRecipeStep) && $valid;

            $stepingredientsIDs = [];
            $stepinstructionsIDs = [];
            if (isset($_POST['RecipeStepIngredient'][0][0])) {
                foreach ($_POST['RecipeStepIngredient'] as $indexRecipeStep => $stepingredients) {
                    $stepingredientsIDs = ArrayHelper::merge($stepingredientsIDs, array_filter(ArrayHelper::getColumn($stepingredients, 'recipe_step_ingredient_id')));
                    foreach ($stepingredients as $indexStepIngredient => $stepIngredient) {
                        $data['RecipeStepIngredient'] = $stepIngredient;
                        $modelStepIngredient = (isset($stepIngredient['recipe_step_ingredient_id']) && isset($oldStepIngridents[$stepIngredient['recipe_step_ingredient_id']])) ? $oldStepIngridents[$stepIngredient['recipe_step_ingredient_id']] : new RecipeStepIngredient;
                        $modelStepIngredient->load($data);
                        $modelsStepIngredient[$indexRecipeStep][$indexStepIngredient] = $modelStepIngredient;
                        $valid = $modelStepIngredient->validate();
                    }
                }
            }
            
            if (isset($_POST['RecipeStepInstruction'][0][0])) {
                foreach ($_POST['RecipeStepInstruction'] as $indexRecipeStep => $stepinstructions) {
                    $stepinstructionsIDs = ArrayHelper::merge($stepinstructionsIDs, array_filter(ArrayHelper::getColumn($stepinstructions, 'recipe_step_instruction_id')));
                    foreach ($stepinstructions as $indexStepInstruction => $stepInstruction) {
                        $data['RecipeStepInstruction'] = $stepInstruction;
                        $modelStepInstruction = (isset($stepInstruction['recipe_step_instruction_id']) && isset($oldStepInstructions[$stepInstruction['recipe_step_instruction_id']])) ? $oldStepInstructions[$stepInstruction['recipe_step_instruction_id']] : new RecipeStepInstruction;
                        $modelStepInstruction->load($data);
                        $modelsStepInstruction[$indexRecipeStep][$indexStepInstruction] = $modelStepInstruction;
                        $valid = $modelStepInstruction->validate();
                    }
                }
            }

            $oldStepIngridentsIDs = ArrayHelper::getColumn($oldStepIngridents, 'recipe_step_ingredient_id');
            $deletedStepIngredientsIDs = array_diff($oldStepIngridentsIDs, $stepingredientsIDs);
            
            $oldStepInstructionsIDs = ArrayHelper::getColumn($oldStepInstructions, 'recipe_step_instruction_id');
            $deletedStepInstructionsIDs = array_diff($oldStepInstructionsIDs, $stepinstructionsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelRecipe->save(false)) {

                        if (! empty($deletedStepIngredientsIDs)) {
                            RecipeStepIngredient::deleteAll(['recipe_step_ingredient_id' => $deletedStepIngredientsIDs]);
                        }
                        
                        if (! empty($deletedStepInstructionsIDs)) {
                            RecipeStepInstruction::deleteAll(['recipe_step_instruction_id' => $deletedStepInstructionsIDs]);
                        }

                        if (! empty($deletedRecipeStepIDs)) {
                            RecipeStep::deleteAll(['recipe_step_id' => $deletedRecipeStepIDs]);
                        }

                        foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {

                            if ($flag === false) {
                                break;
                            }

                            $modelRecipeStep->recipe_id = $modelRecipe->recipe_id;

//                            $modelRecipeStep->save();
                            
                            if (!($flag = $modelRecipeStep->save(false))) {
                                break;
                            }

                            if (isset($modelsStepIngredient[$indexRecipeStep]) && is_array($modelsStepIngredient[$indexRecipeStep])) {
                                foreach ($modelsStepIngredient[$indexRecipeStep] as $indexStepIngredient => $modelStepIngredient) {
                                    $modelStepIngredient->recipe_step_id = $modelRecipeStep->recipe_step_id;
                                    if (!($flag = $modelStepIngredient->save(false))) {
                                        break;
                                    }
                                }
                            }
                            
                            if (isset($modelsStepInstruction[$indexRecipeStep]) && is_array($modelsStepInstruction[$indexRecipeStep])) {
                                foreach ($modelsStepInstruction[$indexRecipeStep] as $indexStepInstruction => $modelStepInstruction) {
                                    $modelStepInstruction->recipe_step_id = $modelRecipeStep->recipe_step_id;
                                    if (!($flag = $modelStepInstruction->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelRecipe->recipe_id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
         return $this->render('update', [
            'modelRecipe' => $modelRecipe,
            'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
            'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,
            'modelsStepInstruction' => (empty($modelsStepInstruction)) ? [[new RecipeStepInstruction]] : $modelsStepInstruction,
        ]);
    }

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
