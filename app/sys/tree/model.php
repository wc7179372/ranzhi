<?php
/**
 * The model file of tree module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
class treeModel extends model
{
    /**
     * Get category info by id.
     * 
     * @param  int|string  $categoryID 
     * @param  string      $type 
     * @access public
     * @return bool|object
     */
    public function getByID($categoryID, $type = 'article')
    {
        $category = $this->dao->select('*')->from(TABLE_CATEGORY)->where('alias')->eq($categoryID)->andWhere('type')->eq($type)->fetch();
        if(!$category) $category = $this->dao->findById((int)$categoryID)->from(TABLE_CATEGORY)->fetch();

        if(!$category) return false;

        if($type == 'forum') 
        {
            $speakers = array();
            $category->moderators = explode(',', trim($category->moderators, ','));
            foreach($category->moderators as $moderators) $speakers[] = $moderators;
            $speakers = $this->loadModel('user')->getRealNamePairs($speakers);
            foreach($category->moderators as $key => $moderators) $category->moderators[$key] = isset($speakers[$moderators]) ? $speakers[$moderators] : '';
            $category->moderators = implode(',', $category->moderators);
        }

        $category->pathNames = $this->dao->select('id, name')->from(TABLE_CATEGORY)->where('id')->in($category->path)->orderBy('grade')->fetchPairs();
        return $category;
    }

    /**
     * Get the first category.
     * 
     * @param  string $type 
     * @param  int    $root 
     * @access public
     * @return object|bool
     */
    public function getFirst($type = 'article', $root = 0)
    {
        return $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('type')->eq($type)
            ->beginIF($root)->andWhere('root')->eq((int)$root)->fi()
            ->orderBy('id')->limit(1)->fetch();
    }

    /**
     * Get the id => name pairs of some categories.
     * 
     * @param  string $categories   the category lists
     * @param  string $type         the type
     * @access public
     * @return array
     */
    public function getPairs($categories = '', $type = 'article')
    {
        return $this->dao->select('id, name')->from(TABLE_CATEGORY)
            ->beginIF($categories)->where('id')->in($categories)->fi()
            ->beginIF($type)->where('type')->eq($type)->fi()
            ->fetchPairs();
    }

    /**
     * Get origin of a category.
     * 
     * @param  int     $categoryID 
     * @access public
     * @return array
     */
    public function getOrigin($categoryID)
    {
        if($categoryID == 0) return array();

        $path = $this->dao->select('path')->from(TABLE_CATEGORY)->where('id')->eq((int)$categoryID)->fetch('path');
        $path = trim($path, ',');
        if(!$path) return array();

        return $this->dao->select('*')->from(TABLE_CATEGORY)->where('id')->in($path)->orderBy('grade')->fetchAll('id');
    }

    /**
     * Get id list of a family.
     * 
     * @param  int      $categoryID 
     * @param  string   $type 
     * @param  int      $root 
     * @access public
     * @return array
     */
    public function getFamily($categoryID, $type = '', $root = 0)
    {
        if($categoryID == 0 and empty($type)) return array();
        $category = $this->getById($categoryID);

        if($category)  return $this->dao->select('id')->from(TABLE_CATEGORY)->where('path')->like($category->path . '%')->fetchPairs();
        if(!$category)
        {
            return $this->dao->select('id')->from(TABLE_CATEGORY)
                ->where('type')->eq($type)
                ->beginIF($root)->andWhere('root')->eq((int)$root)->fi()
                ->fetchPairs();
        }
    }

    /**
     * Get children categories of one category.
     * 
     * @param  int      $categoryID 
     * @param  string   $type 
     * @param  int      $root 
     * @access public
     * @return array
     */
    public function getChildren($categoryID, $type = 'article', $root = 0)
    {
        return $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('parent')->eq((int)$categoryID)
            ->andWhere('type')->eq($type)
            ->beginIF($root)->andWhere('root')->eq((int)$root)->fi()
            ->orderBy('`order`')
            ->fetchAll('id');
    }

    /**
     * Build the sql to execute.
     * 
     * @param string $type              the tree type, for example, article|forum
     * @param int    $startCategory     the start category id
     * @param int    $root
     * @access public
     * @return string
     */
    public function buildQuery($type, $startCategory = 0, $root = 0)
    {
        /* Get the start category path according the $startCategory. */
        $startPath = '';
        if($startCategory > 0)
        {
            $startCategory = $this->getById($startCategory);
            if($startCategory) $startPath = $startCategory->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('type')->eq($type)
            ->beginIF($root)->andWhere('root')->eq((int)$root)->fi()
            ->beginIF($startPath)->andWhere('path')->like($startPath)->fi()
            ->orderBy('grade desc, `order`')
            ->get();
    }

    /**
     * Create a tree menu in <select> tag.
     * 
     * @param  string $type 
     * @param  int    $startCategory 
     * @param  bool   $removeRoot 
     * @param  int    $root 
     * @access public
     * @return string
     */
    public function getOptionMenu($type = 'article', $startCategory = 0, $removeRoot = false, $root = 0)
    {
        /* First, get all categories. */
        $treeMenu   = array();
        $lastMenu   = array();
        $stmt       = $this->dbh->query($this->buildQuery($type, $startCategory, $root));
        $categories = array();
        while($category = $stmt->fetch()) $categories[$category->id] = $category;

        /* Cycle them, build the select control.  */
        foreach($categories as $category)
        {
            $origins = explode(',', $category->path);
            $categoryName = '/';
            foreach($origins as $origin)
            {
                if(empty($origin)) continue;
                $categoryName .= $categories[$origin]->name . '/';
            }
            $categoryName = rtrim($categoryName, '/');
            $categoryName .= "|$category->id\n";

            if(isset($treeMenu[$category->id]) and !empty($treeMenu[$category->id]))
            {
                if(isset($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= $categoryName;
                }
                else
                {
                    $treeMenu[$category->parent] = $categoryName;;
                }
                $treeMenu[$category->parent] .= $treeMenu[$category->id];
            }
            else
            {
                if(isset($treeMenu[$category->parent]) and !empty($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= $categoryName;
                }
                else
                {
                    $treeMenu[$category->parent] = $categoryName;
                }    
            }
        }

        $topMenu = @array_pop($treeMenu);
        $topMenu = explode("\n", trim($topMenu));
        if(!$removeRoot) $lastMenu[] = '/';

        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;

            $menu       = explode('|', $menu);
            $label      = array_shift($menu);
            $categoryID = array_pop($menu);
           
            $lastMenu[$categoryID] = $label;
        }

        return $lastMenu;
    }

    /**
     * Get the tree menu in <ul><ol> type.
     * 
     * @param string    $type           the tree type
     * @param int       $startCategoryID  the start category
     * @param string    $userFunc       which function to be called to create the link
     * @access public
     * @return string   the html code of the tree menu.
     */
    public function getTreeMenu($type = 'article', $startCategoryID = 0, $userFunc, $root = 0)
    {
        $treeMenu = array();
        $stmt = $this->dbh->query($this->buildQuery($type, $startCategoryID, $root));
        while($category = $stmt->fetch())
        {
            $linkHtml = call_user_func($userFunc, $category);

            if(isset($treeMenu[$category->id]) and !empty($treeMenu[$category->id]))
            {
                if(!isset($treeMenu[$category->parent])) $treeMenu[$category->parent] = '';
                $treeMenu[$category->parent] .= "<li>$linkHtml";  
                $treeMenu[$category->parent] .= "<ul>".$treeMenu[$category->id]."</ul>\n";
            }
            else
            {
                if(isset($treeMenu[$category->parent]) and !empty($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= "<li>$linkHtml\n";  
                }
                else
                {
                    $treeMenu[$category->parent] = "<li>$linkHtml\n";  
                }    
            }
            $treeMenu[$category->parent] .= "</li>\n"; 
        }
        $lastMenu = "<ul class='tree'>" . @array_pop($treeMenu) . "</ul>\n";
        return $lastMenu; 
    }

    /**
     * Get productDoc tree menu.
     * 
     * @access public
     * @return string
     */
    public function getProductDocTreeMenu()
    {
        $menu = "<ul class='tree'>";
        $products = $this->loadModel('product', 'crm')->getPairs();
        $modules  = $this->dao->findByType('productdoc')->from(TABLE_CATEGORY)->orderBy('`order`')->fetchAll();
        $projectModules = $this->dao->findByType('projectdoc')->from(TABLE_CATEGORY)->orderBy('`order`')->fetchAll();

        foreach($products as $productID =>$productName)
        {
            $menu .= '<li>';
            $menu .= html::a(helper::createLink('doc', 'browse', "libID=product&module=0&productID=$productID"), $productName);
            if($modules)
            {
                $menu .= '<ul>';
                foreach($modules as $module)
                {
                    $menu .= '<li>' . html::a(helper::createLink('doc', 'browse', "libID=product&module=$module->id&productID=$productID"), $module->name) . '</li>';    
                }
                
                /* If $projectModules not emtpy, append the project modules. */
                if($projectModules)
                {   
                    $menu .= '<li>';
                    $menu .= html::a(helper::createLink('doc', 'browse', "libID=product&module=0&productID=$productID&projectID=int"), $this->lang->tree->projectDoc);       
                    $menu .= '<ul>';

                    foreach($projectModules as $module)
                    {
                        $menu .= '<li>' . html::a(helper::createLink('doc', 'browse', "libID=product&module=$module->id&productID=$productID"), $module->name) . '</li>';
                    } 

                    $menu .= '</ul></li>';
                } 

                $menu .= '</ul>';
            } 

            $menu .='</li>';
        }

        $menu .= '</ul>';
        return $menu;
    }

    /**
     * Get projectDoc tree menu.
     * 
     * @access public
     * @return string
     */
    public function getProjectDocTreeMenu()
    {
        $menu  = "<ul class='tree'>";
        $menu .= "</ul>";
        return $menu;
    }

    /**
     * Create the forum board link.
     * 
     * @param  object      $board 
     * @access public
     * @return string
     */
    public static function createForumBoardLink($board)
    {
        if($board->parent)
        {
            $linkHtml = html::a(helper::createLink('forum', 'board', "id={$board->id}"), $board->name, "id='board{$board->id}'");
        }
        else
        {
            $linkHtml = $board->name;
        }

        return $linkHtml;
    }

    /**
     * Create doc link.
     * 
     * @param  object    $category 
     * @static
     * @access public
     * @return string
     */
    public static function createDocLink($category)
    {
        $linkHtml = html::a(helper::createLink('doc', 'browse', "libID={$category->root}&moduleID={$category->id}"), $category->name, "id='doc{$category->id}'");
        return $linkHtml;
    }

    /**
     * Create the product browse link.
     * 
     * @param  object      $category 
     * @access public
     * @return string
     */
    public static function createProductBrowseLink($category)
    {
        $linkHtml = html::a(helper::createLink('product', 'browse', "categoryID={$category->id}"), $category->name, "id='category{$category->id}'");
        return $linkHtml;
    }

    /**
     * Create the blog browse link.
     * 
     * @param  object      $category 
     * @access public
     * @return string
     */
    public static function createBlogBrowseLink($category)
    {
        $linkHtml = html::a(helper::createLink('blog', 'index', "category={$category->id}"), $category->name, "id='category{$category->id}'");
        return $linkHtml;
    }

    /**
     * Create dept colleague link.
     * 
     * @param  object    $category 
     * @static
     * @access public
     * @return string
     */
    public static function createDeptColleagueLink($category)
    {
        return html::a(helper::createLink('user', 'colleague', "deptID={$category->id}"), $category->name, "id='category{$category->id}'");
    }

    /**
     * Create dept admin link 
     * 
     * @param  object    $category 
     * @static
     * @access public
     * @return string
     */
    public static function createDeptAdminLink($category)
    {
        return html::a(helper::createLink('user', 'admin', "deptID={$category->id}"), $category->name, "id='category{$category->id}'");
    }

    /**
     * Create the manage link.
     * 
     * @param  object         $category 
     * @access public
     * @return string
     */
    public static function createManageLink($category)
    {
        global $lang;

        /* Set the class of children link. */
        $childrenLinkClass = '';
        if($category->type == 'forum' and $category->grade == 2) $childrenLinkClass = 'hidden';

        $linkHtml  = $category->name;
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'edit',     "category={$category->id}"), $lang->tree->edit, "class='ajax'");
        if(strpos($category->type, 'doc') === false) $linkHtml .= ' ' . html::a(helper::createLink('tree', 'children', "type={$category->type}&category={$category->id}"), $lang->category->children, "class='$childrenLinkClass ajax'");
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'delete',   "category={$category->id}"), $lang->delete, "class='deleter'");

        return $linkHtml;
    }

    /**
     * Update a category.
     * 
     * @param  int     $categoryID 
     * @access public
     * @return void
     */
    public function update($categoryID)
    {
        $category = fixer::input('post')
            ->stripTags('desc', $this->config->allowedTags->admin)
            ->join('moderators', ',')
            ->setDefault('readonly', 0)
            ->get();

        /* Set moderators. */
        if(!isset($category->moderators))
        {
            $category->moderators = '';
        }
        else
        {
            $category->moderators = trim($category->moderators, ',');
            $category->moderators = empty($category->moderators) ? '' : ',' . $category->moderators . ',';
        }

        $parent = $this->getById($this->post->parent);
        $category->grade = $parent ? $parent->grade + 1 : 1;

        $this->dao->update(TABLE_CATEGORY)
            ->data($category, $skip = 'uid')
            ->autoCheck()
            ->check('name', 'notempty')
            ->where('id')->eq($categoryID)
            ->exec();

        $this->fixPath($category->type);

        return !dao::isError();
    }
        
    /**
     * Delete a category.
     * 
     * @param  int     $categoryID 
     * @access public
     * @return void
     */
    public function delete($categoryID, $null = null)
    {
        $category = $this->getById($categoryID);
        $family   = $this->getFamily($categoryID);

        $this->dao->update(TABLE_CATEGORY)->set('grade = grade - 1')->where('id')->in($family)->exec();                      // Update family's grade.
        $this->dao->update(TABLE_CATEGORY)->set('parent')->eq($category->parent)->where('parent')->eq($categoryID)->exec();  // Update children's parent to their grandpa.
        $this->dao->delete()->from(TABLE_CATEGORY)->where('id')->eq($categoryID)->exec();                                    // Delete my self.
        $this->fixPath($category->type);

        return !dao::isError();
    }

    /**
     * Manage children of one category.
     * 
     * @param string $type 
     * @param string $children 
     * @param int    $root 
     * @access public
     * @return void
     */
    public function manageChildren($type, $parent, $children, $root = 0)
    {
        /* Get parent. */
        $parent = $this->getByID($parent);

        /* Init the category object. */
        $category = new stdclass();
        $category->parent     = $parent ? $parent->id : 0;
        $category->grade      = $parent ? $parent->grade + 1 : 1;
        $category->type       = $type;
        $category->root       = (int)$root;
        $category->postedDate = helper::now();

        $i = 1;
        foreach($children as $key => $categoryName)
        {
            if(empty($categoryName)) continue;

            /* First, save the child without path field. */
            $category->name  = $categoryName;
            $category->order = $this->post->maxOrder + $i * 10;
            $mode = $this->post->mode[$key];

            if($mode == 'new')
            {
                unset($category->id);
                $this->dao->insert(TABLE_CATEGORY)->data($category)->exec();

                /* After saving, update it's path. */
                $categoryID   = $this->dao->lastInsertID();
                $categoryPath = $parent ? $parent->path . $categoryID . ',' : ",$categoryID,";
                $this->dao->update(TABLE_CATEGORY)
                    ->set('path')->eq($categoryPath)
                    ->where('id')->eq($categoryID)
                    ->exec();
                $i ++;
            }
            else
            {
                $categoryID = $key;
                $this->dao->update(TABLE_CATEGORY)
                    ->set('name')->eq($categoryName)
                    ->where('id')->eq($categoryID)
                    ->exec();
            }
        }

        return !dao::isError();
    }

    /**
     * Fix the path, grade fields according to the id and parent fields.
     *
     * @param  string    $type 
     * @access public
     * @return void
     */
    public function fixPath($type)
    {
        /* Get all categories grouped by parent. */
        $groupCategories = $this->dao->select('id, parent')->from(TABLE_CATEGORY)
            ->where('type')->eq($type)
            ->fetchGroup('parent', 'id');
        $categories = array();

        /* Cycle the groupCategories until it has no item any more. */
        while(count($groupCategories) > 0)
        { 
            /* Record the counts before processing. */
            $oldCounts = count($groupCategories);

            foreach($groupCategories as $parentCategoryID => $childCategories)
            {
                /** 
                 * If the parentCategory doesn't exsit in the categories, skip it. 
                 * If exists, compute it's child categories. 
                 */
                if(!isset($categories[$parentCategoryID]) and $parentCategoryID != 0) continue;

                if($parentCategoryID == 0)
                {
                    $parentCategory = new stdclass();
                    $parentCategory->grade = 0;
                    $parentCategory->path  = ',';
                }
                else
                {
                    $parentCategory = $categories[$parentCategoryID];
                }

                /* Compute it's child categories. */
                foreach($childCategories as $childCategoryID => $childCategory)
                {
                    $childCategory->grade = $parentCategory->grade + 1;
                    $childCategory->path  = $parentCategory->path . $childCategory->id . ',';

                    /**
                     * Save child category to categories, 
                     * thus the child of child can compute it's grade and path.
                     */
                    $categories[$childCategoryID] = $childCategory;
                }

                /* Remove it from the groupCategories.*/
                unset($groupCategories[$parentCategoryID]);
            }

            /* If after processing, no category processed, break the cycle. */
            if(count($groupCategories) == $oldCounts) break;
        }

        /* Save categories to database. */
        foreach($categories as $category)
        {
            $this->dao->update(TABLE_CATEGORY)->data($category)
                ->where('id')->eq($category->id)
                ->exec();
        }
    }
}
