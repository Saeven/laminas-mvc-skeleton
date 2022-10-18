<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ReportController extends AbstractActionController
{
    public function __construct()
    {
    }

    public function indexAction(): ViewModel
    {
        return (new ViewModel())->setTerminal($this->getRequest()->isXmlHttpRequest());
    }
}
