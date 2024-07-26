<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the user role';

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
        // $users = User::select('rule', DB::raw('count(*) as total'))->groupBy('rule')->get()->toArray();
        // dd($users);
        $users = User::where('rule', null)
            ->orWhere('rule', '')
            ->orWhere('rule', 'subscriber')
            ->orWhere('rule', 'customer')
            ->get();

        foreach ($users as $user) {
            dump("before: " . $user->rule);
            $user->update(['rule' => 'customer']);
            dump("after: " . $user->rule);
        }

        // DB::beginTransaction();

        // $users = User::all();

        // foreach ($users as $user) {
        //     $user->assignRole($user->rule);
        // }
        // DB::commit();
        return 0;
    }
}
