<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Block\Adminhtml\Block\Edit;

use Magento\Cms\Block\Adminhtml\Block\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * SaveButton in form
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get ButtonData
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90
        ];
    }

    /**
     * Get Url
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', []);
    }
}
