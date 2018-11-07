<?php

namespace Emakina\Blog\Block\Adminhtml\Post\Edit\Buttons;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => 'history.back(-1)',
            'class' => 'back',
            'sort_order' => 10,
        ];
    }
}
