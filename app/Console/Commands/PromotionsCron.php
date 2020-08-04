<?php

namespace App\Console\Commands;

use App\Mail\Promotions;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PromotionsCron extends Command
{
    protected $userRepo;

    protected $signature = 'cron:promotions';

    protected $description = 'Send promotions mail of Shop to customers';

    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    public function handle()
    {
        $users = $this->userRepo->getWhereEqual('role_id', config('roles.customer'));

        foreach ($users as $user) {
            Mail::to($user->email)->send(new Promotions($user));
        }
        $this->info('Success');
    }
}
