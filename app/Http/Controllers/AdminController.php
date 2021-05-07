<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestmentModel;
use App\Models\PlanModel;
use App\Models\User;

class AdminController extends Controller {
    
    public function DashboardView() {
        return view('admin.index');
    }

    public function CreateNewTransaction(Request $request) {
        try {
            $validation = $request->validate([
                'amount' => 'required',
                'type' => 'required',
                'date' => 'required',
                'user_id' => 'required',
                'attachment' => 'required|mimes:jepg,jpg,png|max:12048'
            ]);
    
            if ($request->file()) {
                $file_name = $this->UploadFile($request->file('attachment'));
                $user_id = auth()->user()->id;

                $investment = new InvestmentModel;
                if ($request->input('plan') !== "null") {
                    $investment->plan_id = $request->input('plan');
                }
                $investment->user_id = $request->input('user_id');
                $investment->amount = $request->input('amount');
                $investment->attachment = $file_name;
                if ($request->input('investment_id') !== "null") {
                    $investment->investment_id = $request->input('investment_id');
                }
                $investment->type = $request->input('type');
                $investment->date = $this->convertStringDateToPHPDateTime($request->input('date'));
                $investment->is_cooldown = true;
                $investment->is_lock = true;
                $investment->is_active = true;
                $investment->created_by = $user_id;
                $investment->updated_by = $user_id;
                $investment->save();

                return $this->ApiResponse(self::API_SUCCESS, $investment->id);
            }
            return $this->ApiResponse(self::API_SUCCESS, 'No file attached.', $request);
        } catch (Exception $e) {
            return $this->ApiResponse(self::API_ERROR, $e);
        }
    }

    public function ListAllPlans() {
        $plan = PlanModel::where('is_active', true)->get();
        if ($plan->isEmpty()) {
            return $this->ApiResponse(self::API_FAILED, 'No plans available.');
        }
        return $this->ApiResponse(self::API_SUCCESS, 'List all plans', $plan);
    }

    public function ListAllUsers() {
        $users = User::select('id', 'email', 'name', 'status', 'created_at')->where('level' , '!=', 57)->get();
        return $this->ApiResponse(self::API_SUCCESS, 'List all users', $users);
    }

    public function MonthlyInvestments() {
        $date_today = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
        $recent_date = date('Y-m-d', strtotime('-30 day', strtotime($date_today)));
        $investments_count = InvestmentModel::whereBetween('created_at', [$recent_date, $date_today])->sum('amount');
        return $this->ApiResponse(self::API_SUCCESS, 'List all investments', $investments_count);
    }

    public function YearlyInvestments() {
        $date_today = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
        $recent_date = date('Y-m-d', strtotime('-365 day', strtotime($date_today)));
        $investments_count = InvestmentModel::whereBetween('created_at', [$recent_date, $date_today])->sum('amount');
        return $this->ApiResponse(self::API_SUCCESS, 'List all investments', $investments_count);
    }

    public function ActiveInvestmentByUserId(Request $request) {
        if (! $request->has('user_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No user id.');
        }
        $investments = InvestmentModel::select('plan.name', 'investment.id')
                        ->where('investment.is_active', true)
                        ->where('investment.user_id', $request->input('user_id'))
                        ->where('investment.type', 1)
                        ->leftJoin('plan', 'investment.plan_id', '=', 'plan.id')
                        ->get();
        return $this->ApiResponse(self::API_SUCCESS, 'List all active investments by user id', $investments);
    }

    public function UpdateInvestmentAttachmentById(Request $request) {
        try {
            $validation = $request->validate([
                'attachment' => 'required|mimes:jepg,jpg,png|max:12048'
            ]);
    
            if ($request->file()) {
                $file_name = $this->UploadFile($request->file('attachment'));
                $user_id = auth()->user()->id;

                $investment = InvestmentModel::find($request->input('investment_id'));
                $investment->attachment = $file_name;
                $investment->updated_by = $user_id;
                $investment->save();

                return $this->ApiResponse(self::API_SUCCESS, $investment->id);
            }
            return $this->ApiResponse(self::API_SUCCESS, 'No file attached.', $request);
        } catch (Exception $e) {
            return $this->ApiResponse(self::API_ERROR, $e);
        }
    }

    public function MonthlyInvestmentsHistory() {
        $date_today = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
        $recent_date = date('Y-m-d', strtotime('-30 day', strtotime($date_today)));
        $investments = InvestmentModel::whereBetween('created_at', [$recent_date, $date_today])->get();
        return $this->ApiResponse(self::API_SUCCESS, 'Monthly investments history', $investments);
    }

    public function YearlyInvestmentsHistory() {
        $date_today = date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))));
        $recent_date = date('Y-m-d', strtotime('-365 day', strtotime($date_today)));
        $investments = InvestmentModel::whereBetween('created_at', [$recent_date, $date_today])->get();
        return $this->ApiResponse(self::API_SUCCESS, 'Yearly investments', $investments);
    }

    public function UpdateUserAndInvestmentStatus(Request $request) {
        if (! $request->has('user_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No user id.');
        }
        $user = User::find($request->input('user_id'));
        $user->status = $request->input('status');
        $user->save();
        InvestmentModel::where('user_id', $request->input('user_id'))->update([
            'is_active' => $request->input('status')
        ]);
        return $this->ApiResponse(self::API_SUCCESS, 'User status', $request->input('user_id'));
    }

    /**
     * Private Functions
     */

    private function UploadFile($file) {
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file_path = $file->storeAs('uploads', $file_name, 'public');
        return  '/storage/' . $file_path;
    }
}
