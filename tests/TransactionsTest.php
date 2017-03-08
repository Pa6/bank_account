<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->seed(UsersSeeder::class);
        $this->seed(BalanceSeedTable::class);
        $this->seed(DepositSeedTable::class);
        $this->seed(WithDrawSeedTable::class);

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    //test get all deposit
    public function testgetAllDeposit(){
        $this->call('GET','/api/v1/deposits/'.$this->getSampleDeposit(),[],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => '2017/03/08',
            'amount'            => 20000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,
        ));
    }

    //get all withdraw test method
    public function testgetAllWithDraw(){
        $this->call('GET','/api/v1/withdraws/'.$this->getSampleWithDraw(),[],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => '2017/03/08',
            'amount'            => 5000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,
        ));
    }

    //get all balance test
    public function testGetAllBalances(){
        $this->call('GET','/api/v1/balances',[],[],[],[$this->getSampleBalance()
        ]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'            =>'id',
            'user_id'       =>'1',
            'balance_money' =>'20000',
        ));
    }

    //create deposit test method
    public function testCreateDeposit(){
        $this->call('POST','/api/v1/deposits',[
            'id'                => 'id',
            'date'              => '2017/03/08',
            'amount'            => 5000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,
        ],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => 'date',
            'amount'            => 'amount',
            'number_per_day'    => 'number',
            'status'            => 'status',
            'currency'          => 'currency',
            'user_id'           => 'user_id',

        ));
    }

    //create withdraw test method
    public function testCreateWithDraw(){
        $this->call('POST','/api/v1/withdraws',[
            'id'                => 'id',
            'date'              => '2017/03/08',
            'amount'            => 5000,
            'number_per_day'    => 1,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,
        ],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => 'date',
            'amount'            => 'amount',
            'number_per_day'    => 'number',
            'status'            => 'status',
            'currency'          => 'currency',
            'user_id'           => 'user_id',

        ));
    }

    //update deposit test method
    public function testUpdateDeposit(){
        $this->call('PUT','/api/v1/deposits/'.$this->getSampleDeposit(),[
            'date'              => '2017/03/08',
            'amount'            => 5000,
            'number_per_day'    => 2,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,

        ],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => 'date',
            'amount'            => 'amount',
            'number_per_day'    => 'number',
            'status'            => 'status',
            'currency'          => 'currency',
            'user_id'           => 'user_id',
        ));
    }

    //update withdraw test method
    public function testUpdateWithdraw(){
        $this->call('PUT','/api/v1/withdraws/'.$this->getSampleDeposit(),[
            'date'              => '2017/03/08',
            'amount'            => 5000,
            'number_per_day'    => 2,
            'status'            => 1,
            'currency'          => 'USD',
            'user_id'           => 1,

        ],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'id'                => 'id',
            'date'              => 'date',
            'amount'            => 'amount',
            'number_per_day'    => 'number',
            'status'            => 'status',
            'currency'          => 'currency',
            'user_id'           => 'user_id',
        ));
    }

    //delete deposit test method
    public function testDeleteDeposit(){
        $this->call('DELETE','/api/v1/deposits/'.$this->getSampleDeposit(),[],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'message'=>'message'
        ));
    }

    //delete withdraw test method
    public function testDeleteWithdraw(){
        $this->call('DELETE','/api/v1/withdraws/'.$this->getSampleWithDraw(),[],[],[],[]);
        $this->assertResponseStatus(200);
        $this->seeJsonStructure(array(
            'message'=>'message'
        ));
    }

}
