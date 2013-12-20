<?php
class entryModel extends model
{
    /**
     * Get all entries. 
     * 
     * @access public
     * @return object
     */
    public function getEntries()
    {
        $entries = $this->dao->select('t1.*, t2.pathname as logoPath')->from(TABLE_ENTRY)->alias('t1')
            ->leftJoin(TABLE_FILE)->alias('t2')
            ->on('t1.logo = t2.id')
            ->fetchAll();

        $webPath = $this->loadModel('file')->webPath;
        foreach($entries as $entry)
        {
            if($entry->logoPath) $entry->logoPath = $webPath . $entry->logoPath;
        }

        return $entries;
    }

    /**
     * Get entry by id.
     * 
     * @param  int    $entryID
     * @access public
     * @return object 
     */
    public function getById($entryID)
    {
        $webPath = $this->loadModel('file')->webPath;
        $entry = $this->dao->select('t1.*, t2.pathname as logoPath')->from(TABLE_ENTRY)->alias('t1')
            ->leftJoin(TABLE_FILE)->alias('t2')
            ->on('t1.logo = t2.id')
            ->where('t1.id')->eq($entryID)
            ->fetch();
        if($entry and $entry->logoPath) $entry->logoPath = $webPath . $entry->logoPath;

        return $entry;
    }

    /**
     * Get entry by code.
     * 
     * @param  string $code 
     * @access public
     * @return object 
     */
    public function getByCode($code)
    {
        return $this->dao->select('*')->from(TABLE_ENTRY)->where('code')->eq($code)->fetch(); 
    }

    /**
     * Create entry. 
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $entry = fixer::input('post')->get();
        $this->dao->insert(TABLE_ENTRY)->data($entry)->autoCheck()->batchCheck($this->config->entry->create->requiredFields, 'notempty')->exec();

        if(dao::isError()) return false;

        $entryID = $this->dao->lastInsertID();
        return $entryID;
    }

    /**
     * Update entry.
     * 
     * @param  int    $code 
     * @access public
     * @return void
     */
    public function update($code)
    {
        $oldEntry = $this->getByCode($code);
        $entry    = fixer::input('post')->get();
        if(!isset($entry->visible)) $entry->visible = 0;
        unset($entry->logo);
        $this->dao->update(TABLE_ENTRY)->data($entry)->autoCheck()->batchCheck($this->config->entry->edit->requiredFields, 'notempty')->where('code')->eq($code)->exec();
        return $oldEntry->id;
    }

    /**
     * Delete entry. 
     * 
     * @param  string $code 
     * @access public
     * @return void
     */
    public function delete($code, $table = null)
    { 
        $entry = $this->getByCode($code);
        $this->loadModel('file')->delete($entry->logo);
        $this->dao->delete()->from(TABLE_ENTRY)->where('code')->eq($code)->exec();
        return !dao::isError();
    }

    /**
     * Get key of entry. 
     * 
     * @param  string $entry 
     * @access public
     * @return object 
     */
    public function getAppKey($entry)
    {
        return $this->config->entry->$entry->key;
    }
    /**
     * Create a key.
     * 
     * @access public
     * @return string 
     */
    public function createKey()
    {
        return md5(rand());
    }

    /**
     * Get all departments.
     * 
     * @access public
     * @return object 
     */
    public function getAllDepts()
    {
        return $this->dao->select('*')->from(TABLE_DEPT)->fetchAll();
    }

    /**
     * Get all users. 
     * 
     * @access public
     * @return object 
     */
    public function getAllUsers()
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->fetchAll();
    }
    /**
     * Get entry logo. 
     * 
     * @param  int    $entryID
     * @access public
     * @return bool|object 
     */
    public function getLogo($entryID)
    {
        $entry = $this->getById($entryID);
        if($entry->logo) 
        {
            $logo = $this->loadModel('file')->getById($entry->logo);
            return $logo->pathname;
        }
        return '';
    }

    /**
     * Update entry logo. 
     * 
     * @param  int    $entryID 
     * @access public
     * @return void
     */
    public function updateLogo($entryID)
    {
        //upload logo img.
        $file = $this->loadModel('file')->getUpload('logo');
        if(isset($file[0]))
        {
            $file = $file[0];
            if(@move_uploaded_file($file['tmpname'], $this->file->savePath . $file['pathname']))
            {
                $url =  $this->file->webPath . $file['pathname'];

                $file['addedBy']    = $this->app->user->account;
                $file['addedDate']  = helper::today();
                $file['objectType'] = 'entryLogo';
                $file['objectID']   = $entryID;
                unset($file['tmpname']);
                $this->dao->insert(TABLE_FILE)->data($file)->exec();

                $logoID = $this->dao->lastInsertID();
                $this->dao->update(TABLE_ENTRY)->set('logo')->eq($logoID)->where('id')->eq($entryID)->exec();
            }
            else
            {
                $error = strip_tags(sprintf($this->lang->file->errorCanNotWrite, $this->file->savePath, $this->file->savePath));
                die(js::alert($error));
            }
        }
    }

    /**
     * Reset entry logo. 
     * 
     * @param  int    $entryID 
     * @access public
     * @return void
     */
    public function resetLogo($entryID)
    {
        $this->dao->update(TABLE_ENTRY)->set('logo')->eq(0)->where('id')->eq($entryID)->exec();
    }
}