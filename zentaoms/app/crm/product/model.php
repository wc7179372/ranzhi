<?php
/**
 * The model file of product category of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class productModel extends model
{
    /**
     * Get produt by id.
     * 
     * @param  int    $id 
     * @access public
     * @return int|bool
     */
    public function getByID($id)
    {
       $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($id)->limit(1)->fetch();

       if(!$product) return false;

       return $product;
    }

    /** 
     * Get product list.
     * 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy = 'id_desc', $pager = null)
    {
        $products = $this->dao->select('*')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->page($pager)->fetchAll('id');

        if(!$products) return array();

        return $products;
    }

    /** 
     * Get product pairs.
     * 
     * @param  string  $orderBy 
     * @access public
     * @return array
     */
    public function getPairs($orderBy = 'id_desc')
    {
        return $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('deleted')->eq(0)->orderBy($orderBy)->fetchPairs('id');
    }

    /**
     * Get roles of a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return int|bool
     */
    public function getRoles($productID)
    {
       $roles = $this->dao->select('roles')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch('roles');
       $roles = json_decode($roles);
       return $roles;
    }

    /**
     * Create a product.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $product = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->insert(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->create, 'notempty')
            ->check('code', 'unique')
            ->check('code', 'code')
            ->exec();

        $productID = $this->dao->lastInsertID();

        if(dao::isError()) return false;

        $sql = "CREATE TABLE IF NOT EXISTS `crm_order_{$product->code}` ( `order` mediumint(5) NOT NULL, PRIMARY KEY (`order`)) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        if(!$this->dbh->query($sql)) return false;

        return $productID;
    }

    /**
     * Update a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function update($productID)
    {
        $product = $this->getByID($productID);
        $code    = $product->code;

        $product = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setDefault('deleted', 0)
            ->get();

        $this->dao->update(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->require->edit, 'notempty')
            ->check('code', 'unique', "id<>{$productID}")
            ->check('code', 'code')
            ->where('id')->eq($productID)
            ->exec();

        if(dao::isError()) return false;

        if($code != $product->code)
        {
            $sql = "RENAME TABLE `crm_order_{$code}` TO `crm_order_{$product->code}`" ;
            if(!$this->dbh->query($sql)) return false;
        }

        return !dao::isError();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID, $table = null)
    {
        $this->dao->update(TABLE_PRODUCT)->set('deleted')->eq(1)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }

    /**
     * Get field list.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function getFieldList($productID)
    {
        return $this->dao->select('*')->from(TABLE_ORDERFIELD)->where('product')->eq($productID)->orderBy('`order`')->fetchAll('field');
    }

    /**
     * Build order form of a product.
     * 
     * @param  int       $productID 
     * @param  object    $values 
     * @access public
     * @return void
     */
    public function buildFieldForm($productID, $values = '')
    {
        $form = '';
        $fieldList = $this->getFieldList($productID);
        foreach($fieldList as $field)
        {
            $form .= '<tr><th>';
            $form .= $field->name;
            $form .= '</th><td>';
            $form .= $this->buildControl($field, $values);
            $form .= '</td></tr>';
        }
        return $form;
    }
    
    /**
     * Build control of a field.
     * 
     * @param  int    $field 
     * @param  int    $values 
     * @access public
     * @return void
     */
    public function buildFieldControl($field, $values = null)
    {
        switch($field->control)
        {
            case 'input':
                return html::input($field->field, isset($values->{$field->field}) ? $values->{$field->field} : $field->default);
            case 'textarea':
                return html::input();
            case 'select':
                return html::select($field->field, array_combine($field->options), isset($values->{$field->field}) ? $values->{$field->field} : $field->default);
            case 'radio':
                return html::radio($field->field, array_combine($field->options), isset($values->{$field->field}) ? $values->{$field->field} : $field->default);
            case 'checkbox':
                return html::checkbox($field->field, array_combine($field->options), isset($values->{$field->field}) ? $values->{$field->field} : $field->default);
            case 'date':
                return html::input($field->field, isset($values->{$field->field}) ? $values->{$field->field} : $field->default);
        }
    }

    /**
     * Create a field.
     * 
     * @access public
     * @return int|bool
     */
    public function createField($productID)
    {
        $field = fixer::input('post')->add('product', $productID)->get();
        $product = $this->getByID($productID);
        if(empty($product)) return false;

        $this->dao->insert(TABLE_ORDERFIELD)
            ->data($field)
            ->autoCheck()
            ->check('field', 'unique', "product={$productID}")
            ->batchCheck($this->config->field->require->create, 'notempty')
            ->exec();

        if(dao::isError()) return false;
        $alterQuery = "ALTER TABLE crm_order_{$product->code} ADD `{$field->field}` {$this->config->field->controlTypeList[$field->control]} NOT NULL";
        if($field->default) $alterQuery .= " default {$field->default}";
        if(!$this->dbh->query($alterQuery)) return false;

        return true;
    }

    /**
     * Get action by ID.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function getActionByID($actionID)
    {
        $action =  $this->dao->select('*')->from(TABLE_ORDERACTION)->where('id')->eq($actionID)->fetch();

        $action->conditions = json_decode($action->conditions);
        $action->inputs     = json_decode($action->inputs);
        $action->results    = json_decode($action->results);
        $action->tasks      = json_decode($action->tasks);
        return $action;
    }

    /**
     * Get actions of a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function getActions($productID)
    {
        return $this->dao->select('*')->from(TABLE_ORDERACTION)->where('product')->eq($productID)->fetchAll('id');
    }

    /**
     * Create an action of product's order.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function createAction($productID)
    {
        $action = fixer::input('post')->add('product', $productID)->get();

        $this->dao->insert(TABLE_ORDERACTION)
            ->data($action)
            ->autoCheck()
            ->batchCheck($this->config->action->require->create, 'notempty')
            ->exec();
        return !dao::isError();
    }

    /**
     * Save conditions of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function saveConditions($actionID)
    {
        foreach($_POST['field'] as $key => $field)
        {
            if(empty($field) or empty($_POST['operater'][$key])) continue;
            $conditions[$field] = array('operater' => $_POST['operater'][$key], 'value' => $_POST['value'][$key]);
        }

        $this->dao->update(TABLE_ORDERACTION)->set('conditions')->eq(json_encode($conditions))->where('id')->eq($actionID)->exec();
        return !dao::isError();
    }

    /**
     * Save inputs of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function saveInputs($actionID)
    {
        foreach($_POST['field'] as $key => $field)
        {
            if(empty($field)) continue;
            $inputs[$field]['rules']   = join($_POST['rules'][$key], ',');
            $inputs[$field]['default'] = $_POST['default'][$key];
        }

        $this->dao->update(TABLE_ORDERACTION)->set('inputs')->eq(json_encode($inputs))->where('id')->eq($actionID)->exec();
        return !dao::isError();
    }

    /**
     * Manage a product's roles.
     *
     * @param  int    $productID 
     * @access public
     * @return bool
     */
    public function manageRoles($productID)
    {
        $roles = array_filter($_POST['roles']);
        $roles = helper::jsonEncode($roles);
        $this->dao->update(TABLE_PRODUCT)->set('roles')->eq($roles)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }
}
