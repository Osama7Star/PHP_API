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

            // validate person and houses models
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
                        $modelsStepIngredient[$indexRecipeStep][$indexStepInstruction] = $modelStepInstruction;
                        $valid = $modelStepInstruction->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    
                    $recipeimageName = $modelRecipe->e_name;
                    $modelRecipe->file = UploadedFile::getInstance($modelRecipe,'file');
                    
                    //Set the path that the file will be uploaded to
                    $path = Yii::getAlias('@api') .'/web/uploads/recipes/';
                    $modelRecipe->file->saveAs($path.$recipeimageName.'.'.$modelRecipe->file->extension);
                    $modelRecipe->image = 'uploads/'.$recipeimageName.'.'.$modelRecipe->file->extension;
                    
                    
                    if ($flag = $modelRecipe->save(false)) {
                        foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {

                            if ($flag === false) {
                                break;
                            }
                            
//                            $recipestepimage = $modelRecipe->e_name;
//                            $modelRecipeStep->file = UploadedFile::getInstance($modelRecipeStep,'file');

//                            print_r($modelRecipeStep->file);
//                            die;
                            
                            //Set the path that the file will be uploaded to
//                            $path = Yii::getAlias('@api') .'/web/uploads/steps/';
//                            $modelRecipeStep->file->saveAs($path.$recipestepimage.'.'.$modelRecipeStep->file->extension);
//                            $modelRecipeStep->image = 'uploads/'.$recipestepimage.'.'.$modelRecipeStep->file->extension;

                            $modelRecipeStep->recipe_id = $modelRecipe->recipe_id;

                            if (!($flag = $modelRecipeStep->save(false))) {
                                break;
                            }

                            if (isset($modelsStepIngredient[$indexRecipeStep]) && is_array($modelsStepIngredient[$indexRecipeStep])) {
                                foreach ($modelsStepIngredient[$indexRecipeStep] as $indexStepIngredient => $modelStepIngredient) {
//                                    if(!empty($modelStepIngredient->ingredient_id) && !empty($modelStepIngredient->amount)&& !empty($modelStepIngredient->measure_unit)){         
//                                    $model = $modelStepIngredient::findAll(1);
//                                    if(empty($model))
//                                        echo 'test';
                                    
//                                    print_r($model); 
                                    
//                                    if ($modelStepIngredient->isNewRecord) {
//                                        echo 'test';
//                                            // no previously db data loaded - 
//                                            // new instance of model (new data not saved yet)
//                                        }
//                                    print_r($modelStepIngredient);
//                                    die;
//                                    if(!empty($modelStepIngredient)){
                                    $modelStepIngredient->recipe_step_id = $modelRecipeStep->recipe_step_id;
                                        if (!($flag = $modelStepIngredient->save(false))) {
                                            break;
                                        }
//                                    }
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

        return $this->render('create', [
            'modelRecipe' => $modelRecipe,
            'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
            'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,
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

        if (!empty($modelsRecipeStep)) {
            foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {
                $stepingredients = $modelRecipeStep->recipeStepIngredients;
                $modelsStepIngredient[$indexRecipeStep] = $stepingredients;
                $oldStepIngridents = ArrayHelper::merge(ArrayHelper::index($stepingredients, 'recipe_step_ingredient_id'), $oldStepIngridents);
            }
        }

        if ($modelRecipe->load(Yii::$app->request->post())) {

            // reset
            $modelsStepIngredient = [];

            $oldRecipeStepIDs = ArrayHelper::map($modelsRecipeStep, 'recipe_step_id', 'recipe_step_id');
            print_r($oldRecipeStepIDs);
//            die;
            $modelsRecipeStep = Model1::createMultiple(RecipeStep::classname(), $modelsRecipeStep);
//            print_r($modelsRecipeStep);
//            die;
            Model::loadMultiple($modelsRecipeStep, Yii::$app->request->post());
            $deletedRecipeStepIDs = array_diff($oldRecipeStepIDs, array_filter(ArrayHelper::map($modelsRecipeStep, 'recipe_step_id', 'recipe_step_id')));

            // validate person and houses models
            $valid = $modelRecipe->validate();
            $valid = Model::validateMultiple($modelsRecipeStep) && $valid;

//            echo $valid;
//            die;
            $stepingredientsIDs = [];
            if (isset($_POST['RecipeStepIngredient'][0][0])) {
                foreach ($_POST['RecipeStepIngredient'] as $indexRecipeStep => $stepingredients) {
                    $stepingredientsIDs = ArrayHelper::merge($stepingredientsIDs, array_filter(ArrayHelper::getColumn($stepingredients, 'recipe_step_ingredient_id')));
                    foreach ($stepingredients as $indexStepIngredient => $stepIngredient) {
                        $data['RecipeStepIngredient'] = $stepIngredient;
//                        print_r($modelStepIngredient);
//                        die;
                        $modelStepIngredient = (isset($stepIngredient['recipe_step_ingredient_id']) && isset($oldStepIngridents[$stepIngredient['recipe_step_ingredient_id']])) ? $oldStepIngridents[$stepIngredient['recipe_step_ingredient_id']] : new RecipeStepIngredient;
                        $modelStepIngredient->load($data);
                        $modelsStepIngredient[$indexRecipeStep][$indexStepIngredient] = $modelStepIngredient;
                        $valid = $modelStepIngredient->validate();
                    }
                }
            }

            $oldStepIngridentsIDs = ArrayHelper::getColumn($oldStepIngridents, 'recipe_step_ingredient_id');
            $deletedStepIngredientsIDs = array_diff($oldStepIngridentsIDs, $stepingredientsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelRecipe->save(false)) {

                        if (! empty($deletedStepIngredientsIDs)) {
                            RecipeStepIngredient::deleteAll(['recipe_step_ingredient_id' => $deletedStepIngredientsIDs]);
                        }

                        if (! empty($deletedRecipeStepIDs)) {
                            RecipeStep::deleteAll(['recipe_step_id' => $deletedRecipeStepIDs]);
                        }

                        foreach ($modelsRecipeStep as $indexRecipeStep => $modelRecipeStep) {

                            if ($flag === false) {
                                break;
                            }

                            $modelRecipeStep->recipe_id = $modelRecipe->recipe_id;

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

//        return $this->render('update', [
//            'modelPerson' => $modelPerson,
//            'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
//            'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom
//        ]);
        
         return $this->render('update', [
            'modelRecipe' => $modelRecipe,
            'modelsRecipeStep' => (empty($modelsRecipeStep)) ? [new RecipeStep] : $modelsRecipeStep,
            'modelsStepIngredient' => (empty($modelsStepIngredient)) ? [[new RecipeStepIngredient]] : $modelsStepIngredient,
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
