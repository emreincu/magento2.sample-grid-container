<?php

namespace Emakina\Blog\Ui\Post\Listing\Grid\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    array $components = [],
    array $data = []
) {
    parent::__construct($context, $uiComponentFactory, $components, $data);
}

public function prepareDataSource(array $dataSource)
{
    if (isset($dataSource['data']['items'])) {
        foreach ($dataSource['data']['items'] as & $items) {
            // $items['instock'] is column name
            if ($items['post_status'] == 1) {
                $status = "Activeted";
            } else {
                $status = "Deactiveted";
            }
            //$html = "<a href='" . $this->context->getUrl('emakina_blog/post/ChangeStatus',['post_id'=>$items['post_id']]) . "'>";
            //$html .= __($status);
            //$html .= "</a>";
            //$item[$fieldName] = $html;
            $html = __($status);
            $items['post_status'] = $html;
        }
    }
    
    return $dataSource;
}
}