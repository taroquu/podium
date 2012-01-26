<?php

/**
 * Description of UserPage
 *
 * @author Martin Cassidy
 */
class UserPage extends AbstractAdminTitlePage
{
    /**
     * @Resource
     */
    private $userService;
    
    public function __construct()
    {
        parent::__construct();
        
        $self = $this;
        
        $editCallback = function($id, $userModel) use ($self)
        {
            return new LinkPanel($id, 'Edit', function() use ($self, $userModel)
            {
                $self->setPage(new CreateEditUserPage($userModel->getModelObject()));
            });
        };
        
        $deleteCallback = function($id, $userModel) use ($self)
        {
            return new LinkPanel($id, 'Delete', function() use ($self, $userModel)
            {
                $self->getUserService()->deleteUser($userModel->getModelObject()->id);
            });
        };
        
        $columns = array();
        $columns[] = new \picon\PropertyColumn('Username', 'username');
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new UserDataProvider();
        
        $this->add(new picon\DefaultDataTable('users', $provider, $columns));
        
        $this->add(new \picon\Link('create', function() use ($self)
        {
            $self->setPage(new CreateEditUserPage(new User()));
        }));
    }
    
    protected function getTitle()
    {
        return 'Users';
    }
    
    public function getUserService()
    {
        return $this->userService;
    }
}

?>
