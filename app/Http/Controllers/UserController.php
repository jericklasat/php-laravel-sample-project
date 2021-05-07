<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestmentModel;
use App\Models\InterestHistoryModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    
    public function DashboardView() {
        return view('user.index');
    }
    
    public function ProfileView() {
        return view('user.profile');
    }

    public function ActiveUserDetails() {
        return $this->ApiResponse(self::API_SUCCESS, 'Current User', auth()->user());
    }
    
    public function ActiveUserInvestment() {
        $investments = InvestmentModel::where('user_id', auth()->user()->id)->get();
        if ($investments->isEmpty()) {
            return $this->ApiResponse(self::API_FAILED, 'No investments available.');
        }
        return $this->ApiResponse(self::API_SUCCESS, 'List all user investments', $investments);
    }

    public function AllPayoutsByInvestmentId(Request $request) {
        if (! $request->has('investment_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No investment id.');
        }
        $interest_history = InterestHistoryModel::where('investment_id', $request->input('investment_id'))->where('is_active', true)->sum('amount');
        $addiitonal_investments = InvestmentModel::where('investment_id', $request->input('investment_id'))->where('is_active', true)->sum('amount');
        return $this->ApiResponse(self::API_SUCCESS, 'Payout by investment id', ['interest' => $interest_history, 'additional_investments' => $addiitonal_investments]);
    }

    public function ActiveInvestmentById(Request $request) {
        if (! $request->has('investment_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No investment id.');
        }
        $investments = InvestmentModel::select('plan.name', 'investment.id', 'investment.amount', 'investment.attachment', 'investment.date', 'investment.type')
                        ->where('investment.is_active', true)
                        ->where('investment.investment_id', $request->input('investment_id'))
                        ->orWhere('investment.id', $request->input('investment_id'))
                        ->leftJoin('plan', 'investment.plan_id', '=', 'plan.id')
                        ->get();
        return $this->ApiResponse(self::API_SUCCESS, 'List all active investments by user id', $investments);
    }

    public function UpdateUserProfile(Request $request) {
        if (! $request->has('user_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No user id.');
        }
        $user = User::find($request->input('user_id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return $this->ApiResponse(self::API_SUCCESS, 'Update user by id', []);
    }

    public function AllInterestHistoryByInvestmentId(Request $request) {
        if (! $request->has('investment_id')) {
            return $this->ApiResponse(self::API_FAILED, 'No investment id.');
        }
        $interest_history = InterestHistoryModel::select('plan.name', 'interest_history.amount', 'interest_history.created_at')
            ->where('interest_history.investment_id', $request->input('investment_id'))
            ->where('interest_history.is_active', true)
            ->leftJoin('plan', 'interest_history.plan_id', '=', 'plan.id')
            ->get();
        return $this->ApiResponse(self::API_SUCCESS, 'Interest history by investment id', $interest_history);
    }
}
