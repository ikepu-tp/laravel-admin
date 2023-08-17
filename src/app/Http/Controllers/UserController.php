<?php

namespace ikepu_tp\LaravelAdmin\app\Http\Controllers;

use Illuminate\Http\Request;
use ikepu_tp\LaravelAdmin\app\Http\Requests\UserUpdateRequest;
use ikepu_tp\LaravelAdmin\app\Models\User_grant;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_class = config("laravel-admin.users");
        return view("laravelAdmin::users.index", [
            "users" => $user_class::with("user_grants")->paginate($request->query("per", 10))->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $userUpdateRequest, string $user_id)
    {
        $user_class = config("laravel-admin.users");
        //idの確認
        if (!$user = $user_class::find($user_id)) abort(404);
        //管理者の人数
        if (User_grant::where('grant', 0)->count() < 2 && !in_array(0, $userUpdateRequest->input("grant", []))) return back()->with("error", "管理者は最低でも1人必要です");

        //未選択の権限削除
        $granted = $user->user_grants()->whereNotIn("grant", $userUpdateRequest->input("grant", []));
        if ($granted->exists() && !$granted->delete()) abort(500);

        $grants = array_unique(array_column($user->user_grants->toArray(), "grant")); //現在の権限
        $diff = array_diff($userUpdateRequest->input("grant", []), $grants); //新規
        $insert = [];
        foreach ($diff as $grant) {
            $insert[] = [
                "user_id" => $user_id,
                "grant" => $grant
            ];
        }
        if (!User_grant::insert($insert)) abort(500);
        return back()->with("success", "変更しました");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
