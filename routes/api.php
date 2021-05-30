<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// api/user
// api/register

// 토큰으로 현재 회원정보 가져오기
Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
//    return $request->user();
        return (new UserResource($request->user()))->response();
});

// 회원가입
Route::middleware(['guest:'.config('fortify.guard')])
    ->post('/register', [RegisteredUserController::class, 'store']);

// 로그인
Route::post('/login', function (Request $request){
   // 로그인 리퀘스트
    $request->validate([
       'email' => 'required|email',
       'password' => 'required',
       'device_name' => 'required'
    ]);

    // 해당하는 사용자 찾기
    $user = User::where('email', $request->email)->first();

    // 로그인 실패 처리
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
           'email' => ['이메일 혹은 비밀번호가 일치하지 않습니다.']
        ]);
    }

    // 토큰 반환
    return $user->createToken($request->device_name)->plainTextToken;
});

// 로그아웃 처리
Route::middleware('auth:sanctum')
    ->post('/logout', function(Request $request){

        // 현재 사용자의 모든 토큰들을 만료 시킴
        $request->user()->tokens()->delete();
        return response('토큰만료 성공', 200)
            ->header('Content-Type', 'text/plain');
    });
