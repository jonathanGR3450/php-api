<?php

namespace Api\Employees\Userinterface\Controller;

use Api\Employees\Application\UseCase\IndexEmployeesUseCase;
use Api\Shared\UserInterface\BaseController;

class GetEmployeesController extends BaseController
{
    private IndexEmployeesUseCase $indexEmployeesUseCase;
    public function __construct(IndexEmployeesUseCase $indexEmployeesUseCase)
    {
        $this->indexEmployeesUseCase = $indexEmployeesUseCase;
    }

    public function __invoke()
    {
        try {
            $data = $this->indexEmployeesUseCase->__invoke(
                $this->queryGet('offset', null),
                $this->queryGet('lastName', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'Get all payment methods successfull',
                'data' => $data
            ];

            $this->sendOutput(
                json_encode($data),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
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
