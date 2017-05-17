<?php

namespace app\modules\products\modules\admin\controllers;

use kartik\tree\controllers\NodeController;
use kartik\tree\models\Tree;
use kartik\tree\TreeView;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

/**
 * Description of NodeController
 *
 * @author darek
 */
class ProductNodeController extends NodeController {

    /**
     * Saves a node once form is submitted
     */
    public function actionSave() {
        $post = Yii::$app->request->post();
        static::checkValidRequest(false, !isset($post['treeNodeModify']));
        $treeNodeModify = $parentKey = $currUrl = $treeSaveHash = null;
        $modelClass = '\kartik\tree\models\Tree';
        $data = static::getPostData();
        extract($data);
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        /**
         * @var Tree $modelClass
         * @var Tree $node
         * @var Tree $parent
         */
        if ($treeNodeModify) {
            $node = new $modelClass;
            $successMsg = Yii::t('kvtree', 'The node was successfully created.');
            $errorMsg = Yii::t('kvtree', 'Error while creating the node. Please try again later.');
        } else {
            $tag = explode("\\", $modelClass);
            $tag = array_pop($tag);
            $id = $post[$tag][$keyAttr];
            $node = $modelClass::findOne($id);
            $successMsg = Yii::t('kvtree', 'Saved the node details successfully.');
            $errorMsg = Yii::t('kvtree', 'Error while saving the node. Please try again later.');
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;
        $node->load($post);
        if ($treeNodeModify) {
            if ($parentKey == TreeView::ROOT_KEY) {
                $node->makeRoot();
            } else {
                $parent = $modelClass::findOne($parentKey);
                $node->appendTo($parent);
            }
        }
        
        $errors = $success = false;
        if ($node->save()) {
            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "Node # {id} - '{name}': {error}", $err) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }
        if (Yii::$app->has('session')) {
            $session = Yii::$app->session;
            $session->set(ArrayHelper::getValue($post, 'nodeSelected', 'kvNodeId'), $node->{$keyAttr});
            if ($success) {
                $session->setFlash('success', $successMsg);
            } else {
                $session->setFlash('error', $errorMsg);
            }
        } elseif (!$success) {
            throw new ErrorException("Error saving node!\n{$errorMsg}");
        }
        return $this->redirect($currUrl);
    }

}
