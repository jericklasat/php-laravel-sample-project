<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlanModel;
use App\Models\InvestmentModel;
use App\Models\InterestHistoryModel;
use Illuminate\Support\Facades\Log;

class CheckInvestmentCooldown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:check_cooldown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check investments cooldown and compute the first interest.';

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
        /**
         * TODO:
         *   Get all investments where record is active, is on cooldown and type = 1
         *   Check if the cooldown is done by comparing date to current date
         *   If cooldown is done
         *       Compute the first interest
         *       Create interest record to database
         *       Update the record and set is_cooldown to false
         */
         
        try {
            $investments = InvestmentModel::select('id', 'plan_id', 'amount', 'date')->where('type', 1)->where('is_cooldown', true)->where('is_active', true)->get();
            foreach($investments as $investment) {
                $current_date = date('Y-m-d');
                $scheduled_date = date('Y-m-d', strtotime('+30 day', strtotime($investment->date)));
                $date_compute = strtotime($scheduled_date) - strtotime($current_date);
                $days_left = $date_compute / 86400;

                if ($days_left <= 0) {
                    // Get additional investment amount of same investment record.
                    $addiitonal_investment_amount = InvestmentModel::where('investment_id', $investment->id)->where('is_active', true)->sum('amount');
                    $interest = $this->ComputeInterest($investment->plan_id, $investment->amount + $addiitonal_investment_amount);
                    $interest_history = new InterestHistoryModel;
                    $interest_history->investment_id = $investment->id;
                    $interest_history->plan_id = $investment->plan_id;
                    $interest_history->amount = $interest;
                    $interest_history->is_active = 1;
                    $interest_history->created_by = 1;
                    $interest_history->updated_by = 1;
                    $interest_history->save();

                    // Update Record
                    $investment_update = InvestmentModel::find($investment->id);
                    $investment_update->is_cooldown = false;
                    $investment_update->save();
                }
            }
            return 'Interest Updated';
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function ComputeInterest($plan_id, $amount) {
        $plan_percentage = PlanModel::select('percentage', 'months_term')->where('id', $plan_id)->first();
        $monthly_interest_rate = $plan_percentage->percentage / $plan_percentage->months_term;
        return $amount * ($monthly_interest_rate / 100);
    }
}
