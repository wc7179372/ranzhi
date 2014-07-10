<?php
/**
 * The control file of trade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     trade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class trade extends control
{
    /** 
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse trade.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $expenseTypes = $this->loadModel('tree')->getPairs(0, 'out');
        $incomeTypes  = $this->loadModel('tree')->getPairs(0, 'in');

        $this->view->title   = $this->lang->trade->browse;
        $this->view->trades  = $this->trade->getList($orderBy, $pager);
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;

        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->customerList  = $this->loadModel('customer', 'crm')->getPairs('client,provider,partner');
        $this->view->deptList      = $this->loadModel('tree')->getPairs(0, 'dept');
        $this->view->categories    = $this->lang->trade->categoryList + $expenseTypes + $incomeTypes;
        $this->view->users         = $this->loadModel('user')->getPairs();

        $this->display();
    }   

    /**
     * Create a contact.
     * 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function create($type = '')
    {
        if($_POST)
        {
            $tradeID = $this->trade->create($type); 
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->loadModel('action')->create('trade', $tradeID, 'Created', '');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title         = $this->lang->trade->{$type};
        $this->view->type          = $type;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->customerList  = $this->loadModel('customer', 'crm')->getPairs('client,partner');
        $this->view->traderList    = $this->loadModel('customer', 'crm')->getPairs('provider,partner');
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
        $this->view->users         = $this->loadModel('user')->getPairs();

        if($type == 'out') $this->view->categories = $this->loadModel('tree')->getOptionMenu('out', 0);
        if($type == 'in')  $this->view->categories = $this->loadModel('tree')->getOptionMenu('in', 0);

        $this->display();
    }

    /**
     * Batch create trade.
     * 
     * @access public
     * @return void
     */
    public function batchCreate()
    {
        if($_POST)
        {
            $result = $this->trade->batchCreate();
            $this->send($result);

            $this->loadModel('action');
            foreach($tradeIDList as $tradeID) $this->action->create('trade', $tradeID, 'Created');

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        unset($this->lang->trade->menu);
        unset($this->lang->trade->typeList['transferin']);
        unset($this->lang->trade->typeList['transferout']);
        $this->view->depositors    = $this->loadModel('depositor')->getPairs();
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->customerList  = $this->loadModel('customer', 'crm')->getPairs('client,partner');
        $this->view->traderList    = $this->loadModel('customer', 'crm')->getPairs('provider,partner');
        $this->view->expenseTypes  = $this->loadModel('tree')->getOptionMenu('out', 0);
        $this->view->incomeTypes   = $this->loadModel('tree')->getOptionMenu('in', 0);
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
        $this->display();
    }

    /**
     * Edit a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function edit($tradeID)
    {
        $trade = $this->trade->getByID($tradeID);
        if(empty($trade)) die();

        if($_POST)
        {
            $changes = $this->trade->update($tradeID);
            if(dao::isError())$this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('trade', $tradeID, 'Edited', '');
                $this->action->logHistory($actionID, $changes);
            }
            
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }
        
        $objectType = array();
        if($trade->order)    $objectType[] = 'order';
        if($trade->contract) $objectType[] = 'contract';
        $this->view->objectType = $objectType;
       
        $this->view->title         = $this->lang->trade->edit;
        $this->view->trade         = $trade;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->customerList  = $this->loadModel('customer', 'crm')->getPairs('client,partner');
        $this->view->traderList    = $this->loadModel('customer', 'crm')->getPairs('provider,partner');
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
       
        if($trade->type == 'out') $this->view->categories = $this->loadModel('tree')->getOptionMenu('out', 0);
        if($trade->type == 'in')  $this->view->categories = $this->loadModel('tree')->getOptionMenu('in', 0);

        $this->display();
    }

    /**
     * Transfer.
     * 
     * @access public
     * @return void
     */
    public function transfer()
    {
        if($_POST)
        {
            $result = $this->trade->transfer(); 
            if(!$result['result']) $this->send(array('result' => 'fail', 'message' => $result['message']));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title         = $this->lang->trade->transfer;
        $this->view->depositorList = $this->loadModel('depositor')->getList();
        $this->view->deptList      = $this->loadModel('tree')->getOptionMenu('dept', 0, $removeRoot = true);
        $this->view->users         = $this->loadModel('user')->getPairs();

        $this->display();
    }

    /**
     * manage detail of a trade.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function detail($tradeID)
    {
        $trade = $this->trade->getByID($tradeID);

        if($_POST)
        {
            $result = $this->trade->saveDetail($tradeID); 
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $details = $this->trade->getDetail($tradeID);
        if(empty($details))
        {
            $detail = $trade;
            $detail->desc = '';
            $detail->money = '';
            $details[] = $detail;
        }

        $this->view->title         = $this->lang->trade->detail;
        $this->view->modalWidth    = 760;
        $this->view->trade         = $trade;
        $this->view->details       = $details;
        $this->view->depositorList = $this->loadModel('depositor')->getPairs();
        $this->view->productList   = $this->loadModel('product', 'crm')->getPairs();
        $this->view->orderList     = $this->loadModel('order', 'crm')->getPairs($customerID = 0);
        $this->view->customerList  = $this->loadModel('customer', 'crm')->getPairs('client,provider,partner');
        $this->view->contractList  = $this->loadModel('contract', 'crm')->getPairs($customerID = 0);
        $this->view->users         = $this->loadModel('user')->getPairs();

        if($trade->type == 'out') $this->view->categories = $this->loadModel('tree')->getPairs(0, 'out');
        if($trade->type == 'in')  $this->view->categories = $this->loadModel('tree')->getPairs(0, 'in');

        $this->display();
    }

    /**
     * Import csv. 
     * 
     * @access public
     * @return void
     */
    public function import()
    {
        if($_POST)
        {
            $file = $this->loadModel('file')->getUpload('files');
            $file = $file[0];

            $fc = file_get_contents($file['tmpname']);
            if( $this->post->encode != "utf8") 
            {
                if(function_exists('mb_convert_encoding'))
                {
                    $fc = @mb_convert_encoding($fc, 'utf-8', $this->post->encode);
                }              
                elseif(function_exists('iconv'))
                {
                    $fc = @iconv($this->post->encode, 'utf-8', $fc);
                }
                else
                {              
                    $this->send(array('result' => 'fail', 'success' => $this->lang->testcase->noFunction));
                }              
            }                  
            file_put_contents($this->file->savePath . $file['pathname'], $fc);

            $file = $this->file->savePath . $file['pathname'];
            $this->session->set('importFile', $file);
            $this->send(array('result' => 'success', 'locate' => inlink('showImport', "depositorID={$this->post->depositor}&schemaID={$this->post->schema}")));
        }

        $this->view->title      = $this->lang->trade->import;
        $this->view->schemas    = $this->loadModel('schema')->getPairs();
        $this->view->depositors = $this->loadModel('depositor')->getPairs();
        $this->display();
    }

    /**
     * Show import data.
     * 
     * @param  int    $depositorID 
     * @param  int    $schemaID 
     * @access public
     * @return void
     */
    public function showImport($depositorID, $schemaID)
    {
        if($_POST)
        {
            $return = $this->trade->saveImport($depositorID);

            if($return['result'] == 'success') $this->session->set('importFile', '');
            $this->send($return);
        }

        $schema = $this->loadModel('schema')->getByID($schemaID);

        /* Parse field to col. */
        $fields = explode(',', $this->config->trade->importField);
        $fields = array_flip($fields);
        foreach($fields as $field => $col)
        {
            $col = $schema->$field;

            if($field == 'desc' and $col)
            {
                $cols = explode(',', str_replace(' ', '', $col));
                $fields[$field] = array();
                foreach($cols as $col)
                {
                    if(empty($col)) continue;
                    $order = ord(strtoupper($col)) - ord('A');
                    $fields[$field][$order] = $order;
                }
                continue;
            }

            $fields[$field] = empty($col) ? '' : ord(strtoupper($col)) - ord('A');
        }

        $rows = $this->schema->parseCSV($this->session->importFile);

        unset($this->lang->trade->menu);
        unset($this->lang->trade->typeList['transferin']);
        unset($this->lang->trade->typeList['transferout']);

        $customerList  = $this->loadModel('customer', 'crm')->getPairs('client,partner');
        $traderList    = $this->customer->getPairs('provider,partner');
        $expenseTypes  = $this->loadModel('tree')->getOptionMenu('out', 0);
        $incomeTypes   = $this->tree->getOptionMenu('in', 0);
        $flipCustomers = array_flip($customerList);
        $flipTraders   = array_flip($traderList);
        $flipTypeList  = array_flip($this->lang->trade->typeList);

        $dataList = array();
        foreach($rows as $row)
        {
            if(!isset($row[$fields['money']]) or !is_numeric($row[$fields['money']])) continue;
            $data = array();
            foreach($fields as $field => $col)
            {
                if($field == 'desc' and !empty($col))
                {
                    $data[$field] = '';
                    foreach($fields[$field] as $col) $data[$field] .= isset($row[$col]) ? trim($row[$col]) . "\n" : '';
                    $data[$field] = trim($data[$field]);
                    continue;
                }
                $data[$field] = (!empty($col) and isset($row[$col])) ? trim($row[$col]) : '';
            }

            if(isset($flipTypeList[$data['type']])) $data['type'] = $flipTypeList[$data['type']];
            if($data['type'] == 'out' and isset($flipTraders[$data['customer']]))
            {
                $data['customer'] = $flipTraders[$data['customer']];
            }
            elseif($data['type'] == 'in' and isset($flipCustomers[$data['customer']]))
            {
                $data['customer'] = $flipCustomers[$data['customer']];
            }

            if($data['category'] and in_array($data['type'], array('in', 'out')))
            {
                $categories = $data['type'] == 'out' ? $expenseTypes : $incomeTypes;
                foreach($categories as $id => $category)
                {
                    if(strpos($category, $data['category']) !== false)
                    {
                        $data['category'] = $id;
                        break;
                    }
                }
            }

            unset($data['fee']);
            $dataList[] = $data;

            $fee = trim($row[$fields['fee']]);
            if($schema->fee and $fee)
            {
                $data['source'] = $data['type'];
                $data['type']   = 'fee';
                $data['money']  = $fee;
                $data['desc']   = '';
                $dataList[]    = $data;
            }
        }

        $this->view->trades        = $dataList;
        $this->view->depositor     = $this->loadModel('depositor')->getByID($depositorID);
        $this->view->users         = $this->loadModel('user')->getPairs();
        $this->view->customerList  = $customerList;
        $this->view->traderList    = $traderList;
        $this->view->expenseTypes  = $expenseTypes;
        $this->view->incomeTypes   = $incomeTypes;
        $this->view->deptList      = $this->tree->getOptionMenu('dept', 0, $removeRoot = true);

        $this->display();
    }

    /**
     * Delete a trade.
     * 
     * @param  int      $tradeID 
     * @access public
     * @return void
     */
    public function delete($tradeID)
    {
        if($this->trade->delete($tradeID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
