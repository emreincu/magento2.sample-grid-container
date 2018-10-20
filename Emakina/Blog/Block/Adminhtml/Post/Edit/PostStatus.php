<?php
namespace Emakina\Blog\Block\Adminhtml\Post\Edit;

use Magento\Framework\Option\ArrayInterface;

class PostStatus implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Active',
                'value' => '1',
                'selected' => ''
            ],
            1 => [
                'label' => 'Deactive',
                'value' => '0'
            ],
        ];

        return $options;
    }
}


