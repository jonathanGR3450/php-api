<?php

namespace Api\Customers\Userinterface\Controller;

use Api\Customers\Application\UseCase\CreateUseCase;
use Api\Shared\UserInterface\BaseController;
use Api\Customers\Userinterface\Requests\CustomerFormRequest;

class CreateCustomerController extends BaseController
{
    private CreateUseCase $createUseCase;
    public function __construct(CreateUseCase $createUseCase)
    {
        $this->createUseCase = $createUseCase;
    }

    public function __invoke()
    {
        $validator = new CustomerFormRequest($this->queryAllPost());
        $validator->validate();
        if ($validator->hasErrors()) {
            $validator->printErrors();
        }
        try {
            $result = $this->createUseCase->__invoke(
                $this->queryPost('customerName', null),
                $this->queryPost('contactLastName', null),
                $this->queryPost('contactFirstName', null),
                $this->queryPost('phone', null),
                $this->queryPost('addressLine1', null),
                $this->queryPost('city', null),
                $this->queryPost('country', null),
                $this->queryPost('creditLimit', null),
                $this->queryPost('addressLine2', null),
                $this->queryPost('state', null),
                $this->queryPost('postalCode', null),
                $this->queryPost('salesRepEmployeeNumber', null)
            );

            $data = [
                'status' => 'success',
                'message' => 'create customer successfull',
                'data' => $result
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
