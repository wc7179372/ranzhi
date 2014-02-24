<?php
/**
 * The control file of file module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class file extends control
{
    /**
     * Build the upload form.
     * 
     * @param int $fileCount 
     * @param float $percent 
     * @access public
     * @return void
     */
    public function buildForm($fileCount = 2, $percent = 0.9)
    {
        $this->view->writeable = $this->file->checkSavePath();
        $this->view->fileCount = $fileCount;
        $this->view->percent   = $percent;
        $this->display();
    }

    /**
     * Build the list part of files.
     * 
     * @param array $files
     * @access public
     * @return string
     */
    public function buildList($files)
    {
        $this->view->files = $files;
        $this->display();
    }
    
    /** 
     * Print files. 
     * 
     * @param  array  $files 
     * @param  string $fieldset 
     * @access public
     * @return void
     */
    public function printFiles($files, $fieldset)
    {   
        $this->view->files    = $files;
        $this->view->fieldset = $fieldset;
        $this->display();
    }   

    /**
     * AJAX: the api to recive the file posted through ajax.
     * 
     * @param  string $uid 
     * @access public
     * @return array
     */
    public function ajaxUpload($uid)
    {
        $file = $this->file->getUpload('imgFile');
        $file = $file[0];
        if($file)
        {
            if(!$this->file->checkSavePath()) $this->send(array('error' => 1, 'message' => $this->lang->file->errorUnwritable));
            move_uploaded_file($file['tmpname'], $this->file->savePath . $file['pathname']);
            $url =  $this->file->webPath . $file['pathname'];

            $file['addedBy']   = $this->app->user->account;
            $file['addedDate'] = helper::now();
            $file['editor']    = 1;
            unset($file['tmpname']);
            $this->dao->insert(TABLE_FILE)->data($file, false)->exec();

            $_SESSION['album'][$uid][] = $this->dao->lastInsertID();

            die(json_encode(array('error' => 0, 'url' => $url)));
        }
    }

    /**
     * The list page of an object
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function browse($objectType, $objectID)
    {
        $this->view->writeable  = $this->file->checkSavePath();
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->files      = $this->file->getByObject($objectType, $objectID);
        $this->display();
    }
  
    /**
     * Edit for the file
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $file = $this->file->getById($fileID);
        if(!empty($_POST))
        {
            if(!$this->file->checkSavePath()) $this->send(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable));
            $this->file->edit($fileID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => 'reload'));
        }
        $this->view->file = $file;
        $this->display();
    }

    /**
     * Upload files for an object.
     * 
     * @param  string $objectType 
     * @param  string $objectID 
     * @access public
     * @return void
     */
    public function upload($objectType, $objectID)
    {
        if(!$this->file->checkSavePath()) $this->send(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable));
        $files = $this->file->getUpload('files');
        if($files) $this->file->saveUpload($objectType, $objectID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * Down a file.
     * 
     * @param  int    $fileID 
     * @param  string $mouse 
     * @access public
     * @return void
     */
    public function download($fileID, $mouse = '')
    {
        $file = $this->file->getById($fileID);

        /* Judge the mode, down or open. */
        $mode  = 'down';
        $fileTypes = 'txt|jpg|jpeg|gif|png|bmp|xml|html';
        if(stripos($fileTypes, $file->extension) !== false and $mouse == 'left') $mode = 'open';

        if(!$file->public && $this->app->user->account == 'guest') $this->locate($this->createLink('user', 'login'));

        /* If the mode is open, locate directly. */
        if($mode == 'open')
        {
            if(file_exists($file->realPath))$this->locate($file->webPath);
            $this->app->error("The file you visit $fileID not found.", __FILE__, __LINE__, true);
        }
        else
        {
            /* Down the file. */
            if(file_exists($file->realPath))
            {
                $fileName = $file->title . '.' . $file->extension;
                $fileData = file_get_contents($file->realPath);
                $this->sendDownHeader($fileName, $file->extension, $fileData, filesize($file->realPath));
            }
            else
            {
                $this->app->error("The file you visit $fileID not found.", __FILE__, __LINE__, true);
            }
        }
    }

    /**
     * Allow a file to public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function allow($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(1)->where('id')->eq($fileID)->exec(false);
        $this->send(array( 'result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * Deny a file from public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function deny($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(0)->where('id')->eq($fileID)->exec(false);
        $this->send(array( 'result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * set a image as primary image.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function setPrimary($fileID)
    {
        $file = $this->file->getByID($fileID);
        if(!$file) $this->send(array( 'result' => 'fail', 'message' => $this->lang->fail));

        $this->dao->update(TABLE_FILE)
            ->set('primary')->eq(0)
            ->where('id')->ne($fileID)
            ->andWhere('objectType')->eq($file->objectType)
            ->andWhere('objectID')->eq($file->objectID)
            ->exec(false);

        $this->dao->update(TABLE_FILE)->set('primary')->eq(1)->where('id')->eq($fileID)->exec();

        $this->send(array( 'result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * Export as csv format.
     * 
     * @access public
     * @return void
     */
    public function export2CSV()
    {
        $this->view->fields = $this->post->fields;
        $this->view->rows   = $this->post->rows;
        $output = $this->parse('file', 'export2csv');

        /* If the language is zh-cn, convert to gbk. */
        $clientLang = $this->app->getClientLang();
        if($clientLang == 'zh-cn')
        {
            if(function_exists('mb_convert_encoding'))
            {
                $output = @mb_convert_encoding($output, 'gbk', 'utf-8');
            }
            elseif(function_exists('iconv'))
            {
                $output = @iconv('utf-8', 'gbk', $output);
            }
        }

        $this->sendDownHeader($this->post->fileName, 'csv', $output);
    }

    /**
     * Send the download header to the client.
     * 
     * @param  string    $fileName 
     * @param  string    $extension 
     * @access public
     * @return void
     */
    public function sendDownHeader($fileName, $fileType, $content, $fileSize = 0)
    {
        /* Set the downloading cookie, thus the export form page can use it to judge whether to close the window or not. */
        setcookie('downloading', 1);

        /* Append the extension name auto. */
        $extension = '.' . $fileType;
        if(strpos($fileName, $extension) === false) $fileName .= $extension;

        /* urlencode the filename for ie. */
        if(strpos($this->server->http_user_agent, 'MSIE') !== false) $fileName = urlencode($fileName);

        /* Judge the content type. */
        $mimes = $this->config->file->mimes;
        $contentType = isset($mimes[$fileType]) ? $mimes[$fileType] : $mimes['default'];

        header("Content-type: $contentType");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-length: {$fileSize}");
        header("Pragma: no-cache");
        header("Expires: 0");
        die($content);
    }

    /**
     * Delet a file.
     *
     * @param  int  $fileID
     * @return void
     */
    public function delete($fileID)
    {
        $this->delete->delete($fileID);
        if(!dao::isError()) $this->send(array('result' => 'success')); 
        $this->send(array('result' => 'fail', 'message' => dao::getError())); 
    }

    /**
     * Paste image in kindeditor at firefox and chrome. 
     * 
     * @param  string uid
     * @access public
     * @return void
     */
    public function ajaxPasteImage($uid)
    {
        if($_POST)
        {
            echo $this->file->pasteImage($this->post->editor, $uid);
        }
    }
}
