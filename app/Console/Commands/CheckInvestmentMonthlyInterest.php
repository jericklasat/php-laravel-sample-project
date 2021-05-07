<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckInvestmentMonthlyInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:check_monthly_interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check monthly investments and compute interest';

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
         *    Get all investments where record is active, is not cooldown and type = 1
         *    Check if investment is monthly due by comparing date now and update_at date
         *    If due
         *      Compute the interest
         *      Create Interest record
         *      Check if lock is finished by computing number of interest history by investment id
         *      If yes
         *          set is_lock to false
         *      else
         *          Update the updated_at to date now
         */
        try {
            $investments = InvestmentModel::select('id', 'plan_id', 'amount', 'updated_at')->where('type', 1)->where('is_cooldown', false)->where('is_active', true)->get();
            foreach($investments as $investment) {
                // Check if investment is monthly due by comparing date now and update_at date
                $current_date = date('Y-m-d');
                $last_updated_date = date($investment->updated_at);
                $date_compute = strtotime($current_date) - strtotime($last_updated_date);
                $days_left = $date_compute / 86400;

                // If due
                if ($days_left <= 0) {
                    // Get additional investment amount of same investment record.
                    $addiitonal_investment_amount = InvestmentModel::where('investment_id', $investment->id)->where('is_active', true)->sum('amount');

                    $plan = PlanModel::select('percentage', 'months_term')->where('id', $investment->plan_id)->first();

                    $interest = $this->ComputeInterest($plan->percentage / $plan->months_term, $investment->amount + $addiitonal_investment_amount);
                    $interest_history = new InterestHistoryModel;
                    $interest_history->investment_id = $investment->id;
                    $interest_history->plan_id = $investment->plan_id;
                    $interest_history->amount = $interest;
                    $interest_history->is_active = 1;
                    $interest_history->created_by = 1;
                    $interest_history->updated_by = 1;
                    $interest_history->save();

                    // Check if lock is finished
                    $number_of_interests_history = InterestHistoryModel::where('investment_id', $investment->id)->count();
                    
                    $investment_update = InvestmentModel::find($investment->id);
                    if ($number_of_interests_history >= $plan->months_term) {
                        $investment_update->is_lock = false;
                    } else {
                        $investment_update->updated_at = date('Y-m-d H:m:s');
                    }
                    $investment_update->save();
                }
            }
            return 'Interest Updated';
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function ComputeInterest($percentage, $months_term, $amount) {
        $monthly_interest_rate = $percentage / $months_term;
        return $amount * ($monthly_interest_rate / 100);
    }
}
