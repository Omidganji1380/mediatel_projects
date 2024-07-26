<?php

namespace App\Console\Commands;

use App\Exports\UsersExport;
use App\Jobs\AdminDailyReportJob;
use App\Mail\Admins\DailyReportMail;
use App\Mail\Admins\MonthlyReportMail;
use App\Mail\Admins\WeeklyReportMail;
use App\Models\Ad\Ad;
use App\Models\AdvertisementOrder;
use App\Models\Shop\Order;
use App\Models\User;
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Swift_TransportException;

class AdminDailyReport extends Command
{
    use ReportTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:admin {interval}';

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
        $mailClass = null;
        if ($this->argument('interval') === 'daily') {
            $startOfDay = now()->startOfDay();
            $endOfDay = now()->endOfDay();

            $users = $this->usersCount($startOfDay, $endOfDay);
            $ads = $this->adsCount($startOfDay, $endOfDay);
            $orders =  $this->ordersTotalPrice($startOfDay, $endOfDay);
            $adOrders =  $this->adOrdersTotalPrice($startOfDay, $endOfDay);
            $orders =  $adOrders + $orders;
            // export file
            $filePath = 'users.xlsx';
            Excel::store(new UsersExport($startOfDay, $endOfDay), $filePath, 'public');
            $filePath = public_path('storage/' . $filePath);
            $mailClass = new DailyReportMail($users, $ads, $orders, $filePath);
            try {
                Mail::to('Kiusk.ca@yahoo.com')->queue($mailClass);
                Mail::to('memoney026@gmail.com')->queue($mailClass);
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }

        } else if ($this->argument('interval') === 'weekly') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $users = $this->usersCount($startOfWeek, $endOfWeek);
            $ads = $this->adsCount($startOfWeek, $endOfWeek);
            $orders =  $this->ordersTotalPrice($startOfWeek, $endOfWeek);
            $adOrders =  $this->adOrdersTotalPrice($startOfWeek, $endOfWeek);
            $orders =  $adOrders + $orders;

            // export file
            $filePath = 'users.xlsx';
            Excel::store(new UsersExport($startOfWeek, $endOfWeek), $filePath, 'public');
            $filePath = public_path('storage/' . $filePath);
            $mailClass = new WeeklyReportMail($users, $ads, $orders, $filePath);
            try {
                Mail::to('Kiusk.ca@yahoo.com')->queue($mailClass);
                Mail::to('memoney026@gmail.com')->queue($mailClass);
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        } else if ($this->argument('interval') === 'monthly') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $users = $this->usersCount($startOfMonth, $endOfMonth);
            $ads = $this->adsCount($startOfMonth, $endOfMonth);
            $orders =  $this->ordersTotalPrice($startOfMonth, $endOfMonth);
            $adOrders =  $this->adOrdersTotalPrice($startOfMonth, $endOfMonth);

            $orders =  $adOrders + $orders;
            $filePath = 'users.xlsx';
            Excel::store(new UsersExport($startOfMonth, $endOfMonth), $filePath, 'public');
            $filePath = public_path('storage/' . $filePath);
            $mailClass = new MonthlyReportMail($users, $ads, $orders, $filePath);
            try {
                Mail::to('Kiusk.ca@yahoo.com')->queue($mailClass);
                Mail::to('memoney026@gmail.com')->queue($mailClass);
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }

        if ($mailClass) {
            // AdminDailyReportJob::dispatch($mailClass);
            return true;
        }
    }
}
