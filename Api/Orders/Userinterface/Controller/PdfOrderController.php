<?php

declare(strict_types=1);

namespace Api\Orders\Userinterface\Controller;

use Api\Orders\Application\UseCase\PdfOrderUseCase;
use Api\Shared\UserInterface\BaseController;

class PdfOrderController extends BaseController
{
    private PdfOrderUseCase $pdfOrderUseCase;
    private int $orderNumber;

    public function __construct(PdfOrderUseCase $pdfOrderUseCase, int $orderNumber)
    {
        $this->pdfOrderUseCase = $pdfOrderUseCase;
        $this->orderNumber = $orderNumber;
    }

    public function __invoke()
    {
        try {
            $pdf = $this->pdfOrderUseCase->__invoke(
                $this->orderNumber
            );

            $this->sendOutput(
                $pdf,
                array('Content-Type: application/pdf', 'Content-Disposition: inline; filename="documento.pdf"')
            );
        } catch (\Exception $e) {
            $this->sendOutput(
                json_encode(array(
                    'status' => 'error',
                    'message' => $e->getMessage().' Something went wrong! Please contact support.',
                    'data' => null
                )),
                array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error')
            );
        }
    }
}
