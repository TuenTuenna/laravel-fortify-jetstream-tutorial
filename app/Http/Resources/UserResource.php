<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
//{
//"id": 6,
//"name": "tester01",
//"email": "tester01@gmail.com",
//"email_verified_at": null,
//"current_team_id": null,
//"profile_photo_path": null,
//"created_at": "2021-05-30T13:47:56.000000Z",
//"updated_at": "2021-05-30T13:47:56.000000Z",
//"profile_photo_url": "https://ui-avatars.com/api/?name=tester01&color=7F9CF5&background=EBF4FF"
//}

    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
//            'name' => $this->name . " 의 이름입니다.",
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url
        ];
    }

    // withResponse 메소드를 사용하면 리스폰스 보낼때 해더값을 이렇게 정해서 줄 수 있다.
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }

}
