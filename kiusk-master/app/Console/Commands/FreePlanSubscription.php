<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\User;
use App\Services\Plans\PlanService;
use Illuminate\Console\Command;

class FreePlanSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        $plan = Plan::where('type', 'free')->firstOrFail();

        foreach($users as $user){
            dump($user->id);
            app(PlanService::class)->subscribe($user, $plan);
        }
    }
}
