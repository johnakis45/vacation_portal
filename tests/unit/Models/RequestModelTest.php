<?php

use PHPUnit\Framework\TestCase;
use App\models\RequestModel;

class RequestModelTest extends TestCase
{
    private $requestModel;

    protected function setUp(): void
    {
        $this->requestModel = new RequestModel();
    }

    public function testInsertRequest()
{
    $this->requestModel->setEmployeeId(2);
    $this->requestModel->setStartDate('2025-02-10');
    $this->requestModel->setEndDate('2025-02-15');
    $this->requestModel->setReason('Vacation');
    $this->requestModel->setStatus('pending');

    $result = $this->requestModel->insertRequest();

    $this->assertTrue($result);
}



public function testFetchUserRequests()
{
    $this->requestModel->setEmployeeId(2);
    $requests = $this->requestModel->fetchUserRequests(2);

    $this->assertIsArray($requests);
    $this->assertNotEmpty($requests);
}

public function testFetchAllRequests()
{
    $requests = $this->requestModel->fetchAllRequests();

    $this->assertIsArray($requests);
    $this->assertNotEmpty($requests);
}

public function testFetchRequest()
{
    $this->requestModel->fetchRequest(3);

    $this->assertEquals('Vacation', $this->requestModel->getReason());
}

public function testApproveRequest()
{
    $result = $this->requestModel->approveRequest(1);

    $this->assertTrue($result);
}

public function testRejectRequest()
{
    $result = $this->requestModel->rejectRequest(1);

    $this->assertTrue($result);
}


public function testValidateRequestValid()
{
    $this->requestModel->setStartDate('2025-02-10');
    $this->requestModel->setEndDate('2025-02-15');
    $this->requestModel->setEmployeeId(2);

    $isValid = $this->requestModel->validateRequest();

    $this->assertFalse($isValid);
}

public function testValidateRequestStartDateLaterThanEndDate()
{
    $this->requestModel->setStartDate('2025-02-16');
    $this->requestModel->setEndDate('2025-02-15');
    $this->requestModel->setEmployeeId(2);

    $isValid = $this->requestModel->validateRequest();

    $this->assertTrue($isValid);
}

public function testValidateRequestStartDateInPast()
{
    $this->requestModel->setStartDate('2024-12-01');
    $this->requestModel->setEndDate('2024-12-05');
    $this->requestModel->setEmployeeId(2);

    $isValid = $this->requestModel->validateRequest();

    $this->assertTrue($isValid);
}


// public function testValidateRequestOverlapping()
// {
//     $this->requestModel->setStartDate('2025-02-10');
//     $this->requestModel->setEndDate('2025-02-15');
//     $this->requestModel->setEmployeeId(2);

//     // Assuming there's already an existing request for this employee
//     $isValid = $this->requestModel->validateRequest();

//     $this->assertTrue($isValid);
// }

public function testRemoveRequest()
{
    $this->requestModel->setId(3);
    $employeeId = $this->requestModel->removeRequest(3);

    $this->assertEquals(2, $employeeId);
}


}
