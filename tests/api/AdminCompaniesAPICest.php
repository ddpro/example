<?php


class AdminCompaniesAPICest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function testNewItem(ApiTester $I)
    {
        $I->wantTo('test companies item fetch via AJAX');
        $I->sendAjaxGetRequest('admin/companies/1', ['id' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['id' => 1]);
    }

    public function testResults(ApiTester $I)
    {
        $I->wantTo('test companies fetch filter results via AJAX');
        $I->sendAjaxPostRequest('admin/companies/results', ['page' => 1]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['page' => 1]);
    }
}
