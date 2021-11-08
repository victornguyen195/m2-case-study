<?php
namespace Smart\ExpertReview\Controller\Adminhtml\ExpertReview;

use Magento\Backend\App\Action;
use Smart\ExpertReview\Model\ExpertReviewFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $expertReviewFactory;

    public function __construct(
        Action\Context $context,
        ExpertReviewFactory $expertReviewFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->expertReviewFactory = $expertReviewFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;
        $newData = [
            'expert_id' => $data['expert_id'],
            'title' => $data['title'],
            'detail' => $data['detail'],
            'link_video' => $data['link_video'],
        ];
        $expertReview = $this->expertReviewFactory->create();
        if ($id) {
            $expertReview->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save success.'));
        }
        try{
            $expertReview->addData($newData);
            //$this->_eventManager->dispatch("vimagento_post_before_save", ['postData' => $post]);
            $expertReview->save();
            return $this->resultRedirect->create()->setPath('catalog/product/edit/id/'.$expertReview->getProductId());
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save fail.'));
        }
    }
}
