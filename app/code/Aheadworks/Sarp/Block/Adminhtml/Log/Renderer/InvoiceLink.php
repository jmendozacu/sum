<?php
namespace Aheadworks\Sarp\Block\Adminhtml\Log\Renderer;

use Aheadworks\Sarp\Block\Adminhtml\Log\RendererInterface;

/**
 * Class InvoiceLink
 * @package Aheadworks\Sarp\Block\Adminhtml\Log\Renderer
 */
class InvoiceLink extends Anchor implements RendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render($data)
    {
        $href = $this->_urlBuilder->getUrl('sales/invoice/view', ['invoice_id' => $data['id']]);
        $this->setHref($href)->setTitle($data['title']);
        return $this->toHtml();
    }
}
