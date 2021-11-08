<?php
namespace Smart\ExpertReview\Controller\Adminhtml\Experts;

use Magento\Backend\App\Action;
use Smart\ExpertReview\Model\ExpertsFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $expertsFactory;

    public function __construct(
        Action\Context $context,
        ExpertsFactory $expertsFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->expertsFactory = $expertsFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;
        $newData = [
            'name' => $data['name'],
            'position' => $data['position'],
            'company' => $data['company'],
        ];
        $experts = $this->expertsFactory->create();
        if ($id) {
            $experts->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save success.'));
        }
        try{
            $experts->addData($newData);
            //$this->_eventManager->dispatch("vimagento_post_before_save", ['postData' => $post]);
            $experts->save();
            return $this->resultRedirect->create()->setPath('smart_expertreview/experts/index');
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save fail.'));
        }
    }
}
