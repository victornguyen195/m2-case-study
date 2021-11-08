<?php
namespace AID\Crud\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use AID\Crud\Model\BookFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $bookFactory;

    public function __construct(
        Action\Context $context,
        BookFactory $bookFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->bookFactory = $bookFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['entity_id']) ? $data['entity_id'] : null;
        $newData = [
            'name' => $data['name'],
            'author' => $data['author'],
            'genre' => $data['genre'],
            'publish_year' => $data['publish_year'],
        ];
        $book = $this->bookFactory->create();
        if ($id) {
            $book->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save success.'));
        }
        try{
            $book->addData($newData);
            $book->save();
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save fail.'));
        }
        return $this->resultRedirect->create()->setPath('crud/index/index');
    }
}
