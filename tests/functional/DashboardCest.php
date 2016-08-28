<?php


class DashboardCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function testDashboard(FunctionalTester $I)
    {
        $I->wantTo('test dashboard page');
        $I->amOnRoute('admin_dashboard');
        $I->seeCurrentUrlEquals('/admin');
        $I->see('Dashboard');
    }
}
