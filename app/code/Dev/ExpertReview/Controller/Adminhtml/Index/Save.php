<?php

namespace Dev\ExpertReview\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Dev\ExpertReview\Model\ExpertFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends Action implements HttpPostActionInterface
{
    private $resultRedirect;
    private $expertFactory;

    public function __construct(
        Action\Context $context,
        ExpertFactory $expertFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->expertFactory = $expertFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['expert_id']) ? $data['expert_id'] : null;
        $newData = [
            'name' => $data['name'],
            'position' => $data['position'],
            'workplace' => $data['workplace']
        ];

        $expert = $this->expertFactory->create();
        if ($id) {
            $expert->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit expert success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save expert success.'));
        }
        try{
            $expert->addData($newData);
            $expert->save();
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save fail.'));
        }

        return $this->resultRedirect->create()->setPath('expert/index/index');
    }
}
