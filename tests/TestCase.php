<?php
/*
 * By Pascal developer
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }


    public function getSampleBalance(){
        $balance = Balance::all()->first();
        return(empty($balance)? null :$balance->id);
    }

    public function getSampleWithDraw(){
        $withdraw = \App\Withdraw::all()->first();
        return (empty($withdraw ? null : $withdraw->id));
    }
}






























