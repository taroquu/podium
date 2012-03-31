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
        
        $this->add(new PodiumFeedbackPanel('feedback'));
        
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
                if($_SESSION['user']->id==$userModel->getModelObject()->id)
                {
                    $self->error('You cannot delete your own user whilst you are logged in');
                }
                else
                {
                    $self->getUserService()->deleteUser($userModel->getModelObject()->id);
                    $self->success('User delete successfully');
                }
            });
        };
        
        $columns = array();
        $columns[] = new \picon\PropertyColumn('Username', 'username');
        $columns[] = new PanelColumn('', $editCallback);
        $columns[] = new PanelColumn('', $deleteCallback);
        
        $provider = new UserDataProvider();
        
        $this->add(new picon\DefaultDataTable('users', $provider, $columns));
        
        $this->add(new ButtonLink('create', function() use ($self)
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
