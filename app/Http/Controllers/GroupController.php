<?php

namespace App\Http\Controllers;

use App\Group;
use App\Session;
use App\Transaction;
use App\UserGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->limit != null) {
            $groupIds = UserGroup::take($request->limit)->where('user_id', $request->user_id)->pluck('group_id');
            error_log($groupIds);
            $groups = Group::whereIn("id", $groupIds)->get();
        } else {
            $groups = Group::all();
        }

        foreach ($groups as $group) {
            $total = $this->collectCurrentAmount($group->id);
            $group->current_balance = $total;
            $group->percentage = number_format((float)$total / $group->target_amount, 2, '.', '');

        }

        return response()->json($groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = Group::create($request->all());

        UserGroup::create([
            "user_id" => $request->user_id,
            "group_id" => $group->id
        ]);

        return response()->json($group);
    }

    private function collectCurrentAmount($groupId) {
        $sessions = Session::where("group_id", $groupId)->get();

        $total = 0;

        foreach ($sessions as $session) {
            $transactions = Transaction::where('session_id', $session->id)->get();

            foreach ($transactions as $transaction) {
                $total += $transaction->amount;
            }
        }

        return $total;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
