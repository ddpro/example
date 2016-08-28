<?php


class AdminCompaniesCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function testIndex(FunctionalTester $I)
    {
        $I->wantTo('test companies index page');
        $I->amOnPage('admin/companies');
        $I->seeCurrentRouteIs('admin_index');
        $I->see('Companies');
    }

    public function testNewItem(FunctionalTester $I)
    {
        $I->wantTo('test companies new item page');
        $I->amOnPage('admin/companies/new');
        $I->seeCurrentRouteIs('admin_new_item');
        $I->see('Companies');
    }
}
