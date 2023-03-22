<?php

declare(strict_types=1);

namespace Api\Payments\Userinterface\Controller;

use Api\Payments\Application\UseCase\PdfPaymentUseCase;
use Api\Shared\UserInterface\BaseController;

class PdfPaymentController extends BaseController
{
    private PdfPaymentUseCase $pdfPaymentUseCase;
    private int $customerNumber;
    private string $checkNumber;

    public function __construct(PdfPaymentUseCase $pdfPaymentUseCase, int $customerNumber, string $checkNumber)
    {
        $this->pdfPaymentUseCase = $pdfPaymentUseCase;
        $this->customerNumber = $customerNumber;
        $this->checkNumber = $checkNumber;
    }

    public function __invoke()
    {
        try {
            $pdf = $this->pdfPaymentUseCase->__invoke(
                $this->customerNumber,
                $this->checkNumber
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
