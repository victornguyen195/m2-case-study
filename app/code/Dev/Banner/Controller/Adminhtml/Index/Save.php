<?php

namespace Dev\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Dev\Banner\Model\BannerFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends Action implements HttpPostActionInterface
{
    private $resultRedirect;
    private $bannerFactory;

    public function __construct(
        Action\Context $context,
        BannerFactory $bannerFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['banner_id']) ? $data['banner_id'] : null;
        $newData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'short_description' => $data['short_description']
        ];

        if (isset($data['image']) && is_array($data['image'])) {
            $strpos = strpos($data['image'][0]['url'],'/media/');
            $data['image'][0]['url'] = substr($data['image'][0]['url'],$strpos + 6);
            $data['image'][0]['url'] = trim($data['image'][0]['url'],'/');
            $newData['image'] = json_encode($data['image']);
        }

        $banner = $this->bannerFactory->create();
        if ($id) {
            $banner->load($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit banner success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save banner success.'));
        }
        try{
            $banner->addData($newData);
            $banner->save();
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save fail.'));
        }

        return $this->resultRedirect->create()->setPath('banner/index/index');
    }
}
