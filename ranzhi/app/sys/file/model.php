<?php
/**
 * The model file of file module of Ranzhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file 
 * @version     $Id$
 * @link        http://www.ranzhi.co
 */
?>
<?php
class fileModel extends model
{
    public $savePath = '';
    public $webPath  = '';
    public $now      = 0;

    /**
     * The construct function, set the save path and web path.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->now = time();
        $this->setSavePath();
        $this->setWebPath();
    }

    /**
     * Get files of an object list.
     * 
     * @param   string  $objectType 
     * @param   mixed   $objectID 
     * @param   bool    $isImage 
     * @access public
     * @return array
     */
    public function getByObject($objectType, $objectID, $isImage = false)
    {
        /* Get files group by objectID. */
        $files = $this->dao->select('*')
            ->from(TABLE_FILE)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->in($objectID)
            ->beginIf($isImage)->andWhere('extension')->in($this->config->file->imageExtensions)->orderBy('`primary`')->fi() 
            ->fetchGroup('objectID');

        /* Process these files. */
        foreach($files as $objectFiles) $this->batchProcessFile($objectFiles);

        /* If object is only an objectID, return it's files, else return all. */
        if(is_numeric($objectID) and !empty($files[$objectID])) return $files[$objectID];
        return $files;
    }

    /**
     * processFile just is image and add smallURL and middleURL if necessary.
     *
     * @param  object $file
     * @return object
     */    
    public function processFile($file)
    {
        $file->fullURL   = $this->webPath . $file->pathname;
        $file->middleURL = '';
        $file->smallURL  = '';
        $file->isImage   = false;

        if(in_array(strtolower($file->extension), $this->config->file->imageExtensions) !== false)
        {
            $file->middleURL = $this->webPath . str_replace('f_', 'm_', $file->pathname);
            $file->smallURL  = $this->webPath . str_replace('f_', 's_', $file->pathname);
            $file->largeURL  = $this->webPath . str_replace('f_', 'l_', $file->pathname);

            if(!file_exists(str_replace($this->webPath, $this->savePath, $file->middleURL))) $file->middleURL = $file->fullURL;
            if(!file_exists(str_replace($this->webPath, $this->savePath, $file->smallURL)))  $file->smallURL  = $file->fullURL;
            if(!file_exists(str_replace($this->webPath, $this->savePath, $file->largeURL)))  $file->largeURL  = $file->fullURL;

            $file->isImage   = true;
        }

        return $file;
    }
    
    /**
     * batch run processFile function.
     * 
     * @param array $files
     * @return array
     */
    public function batchProcessFile($files)
    {
        foreach($files as &$file) $file = $this->processFile($file);
        return $files;
    }

    /**
     * Get info of a file.
     * 
     * @param string $fileID 
     * @access public
     * @return void
     */
    public function getByID($fileID)
    {
        $file = $this->dao->findById($fileID)->from(TABLE_FILE)->fetch();
        $file->realPath = $this->savePath . $file->pathname;
        $file->webPath  = $this->webPath . $file->pathname;

        return $this->processFile($file);
    }

    /**
     * Save the files uploaded.
     * 
     * @param string $objectType 
     * @param string $objectID 
     * @param string $extra 
     * @access public
     * @return void
     */
    public function saveUpload($objectType = '', $objectID = '', $extra = '')
    {
        $fileTitles = array();
        $now        = helper::now();
        $files      = $this->getUpload();

        foreach($files as $id => $file)
        {   
            if(!move_uploaded_file($file['tmpname'], $this->savePath . $file['pathname'])) return false;
            if(in_array(strtolower($file['extension']), $this->config->file->imageExtensions))
            {
                $this->compressImage($this->savePath . $file['pathname']);
            }

            $file['objectType'] = $objectType;
            $file['objectID']   = $objectID;
            $file['addedBy']    = $this->app->user->account;
            $file['addedDate']  = $now;
            $file['extra']      = $extra;
            unset($file['tmpname']);
            $this->dao->insert(TABLE_FILE)->data($file)->exec();
            $fileTitles[$this->dao->lastInsertId()] = $file['title'];
        }
        return $fileTitles;
    }

    /**
     * Get the count of uploaded files.
     * 
     * @access public
     * @return void
     */
    public function getCount()
    {
        return count($this->getUpload());
    }

    /**
     * get uploaded files.
     * 
     * @param string $htmlTagName 
     * @access public
     * @return void
     */
    public function getUpload($htmlTagName = 'files')
    {
        $files = array();
        if(!isset($_FILES[$htmlTagName])) return $files;
        /* The tag if an array. */
        if(is_array($_FILES[$htmlTagName]['name']))
        {
            extract($_FILES[$htmlTagName]);
            foreach($name as $id => $filename)
            {
                if(empty($filename)) continue;
                $file['extension'] = $this->getExtension($filename);
                $file['pathname']  = $this->setPathName($id, $file['extension']);
                $file['title']     = !empty($_POST['labels'][$id]) ? htmlspecialchars($_POST['labels'][$id]) : str_replace('.' . $file['extension'], '', $filename);
                $file['size']      = $size[$id];
                $file['tmpname']   = $tmp_name[$id];
                $files[] = $file;
            }
        }
        else
        {
            if(empty($_FILES[$htmlTagName]['name'])) return $files;
            extract($_FILES[$htmlTagName]);
            $file['extension'] = $this->getExtension($name);
            $file['pathname']  = $this->setPathName(0, $file['extension']);
            $file['title']     = !empty($_POST['labels'][0]) ? htmlspecialchars($_POST['labels'][0]) : substr($name, 0, strpos($name, $file['extension']) - 1);
            $file['size']      = $size;
            $file['tmpname']   = $tmp_name;
            return array($file);
        }
        return $files;
    }

    /**
     * Get extension name of a file.
     * 
     * @param string $filename 
     * @access public
     * @return void
     */
    public function getExtension($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(empty($extension)) return 'txt';
        if(strpos($this->config->file->dangers, $extension) !== false) return 'txt';
        return $extension;
    }

    /**
     * Set the path name.
     * 
     * @param string $fileID 
     * @param string $extension 
     * @access public
     * @return void
     */
    public function setPathName($fileID, $extension)
    {
        $sessionID  = session_id();
        $randString = substr($sessionID, mt_rand(0, strlen($sessionID) - 5), 3);
        $pathName   = date('Ym/dHis', $this->now) . $fileID . mt_rand(0, 10000) . $randString;

        /* rand file name more */
        list($path, $file) = explode('/', $pathName);
        $file = md5(mt_rand(0, 10000) . str_shuffle(md5($file)) . mt_rand(0, 10000));
        return $path . '/f_' . $file . '.' . $extension;
    }

    /**
     * Set the save path.
     * 
     * @access public
     * @return void
     */
    public function setSavePath()
    {
        $savePath = $this->app->getDataRoot() . "upload/" . date('Ym/', $this->now);
        if(!file_exists($savePath)) @mkdir($savePath, 0777, true);
        $this->savePath = dirname($savePath) . '/';
    }
    
    /**
     * Set the web path.
     * 
     * @access public
     * @return void
     */
    public function setWebPath()
    {
        $this->webPath = $this->app->getWebRoot() . "data/upload/";
    }

    /**
     * Edit rile
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $this->replaceFile($fileID);
        
        $fileInfo = fixer::input('post')->remove('upFile')->get();
        $this->dao->update(TABLE_FILE)->data($fileInfo)->autoCheck()->batchCheck('title', 'notempty')->where('id')->eq($fileID)->exec();
    }
    
    /**
     * Replace a file.
     * 
     * @access public
     * @return bool 
     */
    public function replaceFile($fileID, $postName = 'upFile')
    {
        if($files = $this->getUpload($postName))
        {
            $file      = $files[0];
            $fileInfo  = $this->dao->select('pathname, extension')->from(TABLE_FILE)->where('id')->eq($fileID)->fetch();
            $extension = strtolower($file['extension']);

            if($extension != $fileInfo->extension)
            {
                /* Remove old file. */
                if(file_exists($this->savePath . $fileInfo->pathname)) unlink($this->savePath . $fileInfo->pathname);
                foreach($this->config->file->thumbs as $size => $configure)
                {
                    $thumbPath = $this->savePath . str_replace('f_', $size . '_', $fileInfo->pathname);
                    if(file_exists($thumbPath)) unlink($thumbPath);
                }

                $fileInfo->pathname  = str_replace(".{$fileInfo->extension}", ".$extension", $fileInfo->pathname);
                $fileInfo->extension = $extension;
            }

            $realPathName = $this->savePath . $fileInfo->pathname;
            move_uploaded_file($file['tmpname'], $realPathName);
            if(in_array(strtolower($file['extension']), $this->config->file->imageExtensions))
            {
                $this->compressImage($realPathName);
            }

            $fileInfo->addedBy   = $this->app->user->account;
            $fileInfo->addedDate = helper::now();
            $fileInfo->size      = $file['size'];
            $this->dao->update(TABLE_FILE)->data($fileInfo)->where('id')->eq($fileID)->exec();
            return true;
        }
        else
        {
            return false;
        }
    }
 
    /**
     * Delete the record and the file
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function delete($fileID, $null = null)
    {
        $file = $this->getByID($fileID);
        if(file_exists($file->realPath)) unlink($file->realPath);
        if(in_array($file->extension, $this->config->file->imageExtensions))
        {
            foreach($this->config->file->thumbs as $size => $configure)
            {
                $thumbPath = $this->savePath . str_replace('f_', $size . '_', $file->pathname);
                if(file_exists($thumbPath)) unlink($thumbPath);
            }
        }
        $this->dao->delete()->from(TABLE_FILE)->where('id')->eq($file->id)->exec();
        return !dao::isError();
    }

    /**
     * Paste image in kindeditor at firefox and chrome. 
     * 
     * @param  string    $data 
     * @param  string    $uid 
     * @access public
     * @return string
     */
    public function pasteImage($data, $uid)
    {
        $data = str_replace('\"', '"', $data);

        if(!$this->checkSavePath()) return false;

        ini_set('pcre.backtrack_limit', strlen($data));
        preg_match_all('/<img src="(data:image\/(\S+);base64,(\S+))" .+ \/>/U', $data, $out);
        foreach($out[3] as $key => $base64Image)
        {
            $imageData = base64_decode($base64Image);

            $file['extension'] = $out[2][$key];
            $file['pathname']  = $this->setPathName($key, $file['extension']);
            $file['size']      = strlen($imageData);
            $file['addedBy']   = $this->app->user->account;
            $file['addedDate'] = helper::today();
            $file['title']     = basename($file['pathname']);
            $file['editor']    = 1;

            file_put_contents($this->savePath . $file['pathname'], $imageData);
            $this->compressImage($this->savePath . $file['pathname']);
            $this->dao->insert(TABLE_FILE)->data($file)->exec();
            $_SESSION['album'][$uid][] = $this->dao->lastInsertID();

            $data = str_replace($out[1][$key], $this->webPath . $file['pathname'], $data);
        }

        return $data;
    }

    /**
     * Compress image to config configured size.
     * 
     * @param  string    $imagePath 
     * @access public
     * @return void
     */
    public function compressImage($imagePath)
    {
        $this->app->loadClass('phpthumb', true);
        $imageInfo = pathinfo($imagePath);
        if(!is_writable($imageInfo['dirname'])) return false;

        foreach($this->config->file->thumbs as $size => $configure)
        {
            $thumbPath = str_replace('f_', $size . '_', $imagePath);
            if(extension_loaded('gd'))
            {
                $thumb = phpThumbFactory::create($imagePath);
                $thumb->resize($configure['width'], $configure['height']);
                $thumb->save($thumbPath);
            }
            else
            {
                copy($imagePath, $thumbPath);   
            }
        }
    }

    /**
     * Check save path is writeable.
     * 
     * @access public
     * @return void
     */
    public function checkSavePath()
    {
        return is_writable($this->savePath);
    }

    /**
     * Update objectType and objectID for file.
     * 
     * @param  string $uid 
     * @param  int    $objectID 
     * @param  string $bojectType 
     * @access public
     * @return void
     */
    public function updateObjectID($uid, $objectID, $objectType)
    {
        $data = new stdclass();
        $data->objectID   = $objectID;
        $data->objectType = $objectType;
        if(isset($_SESSION['album']) and $_SESSION['album'][$uid])
        {
            $this->dao->update(TABLE_FILE)->data($data)->where('id')->in($_SESSION['album'][$uid])->exec();
            if(dao::isError()) return false;
            return !dao::isError(); 
        }
    }
}
