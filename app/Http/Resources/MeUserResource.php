<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray(Request $request): array
    {
        $user = $this['user'];
        $hr = $this['hr'];

        return [
            'id' => $hr['id'],
            'email' => $user->email,
            'phone' => $user->phone,
            'id_number' => $user->id_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
            'email_verified_at'=>$user->email_verified_at,
            'verified'=>$user->email_verified_at ? true : false,
            'address' => $user->address,
            'nationality' => $user->nationality,
            'date_of_birth' => $user->date_of_birth,
            'roles'       => $user->relationLoaded('roles') ? $user->roles->pluck('name')->toArray() : ['7omar'],
            'permissions' => $user->relationLoaded('permissions') ? $user->permissions->pluck('name')->toArray() : [],
             'branch' => isset($hr['branch']) ? [
                'id' => $hr['branch']['id'] ?? null,
                'name' => $hr['branch']['name'] ?? null,
            ] : null,

            'department' =>isset($hr['department']) ? [
                'id' => $hr['department']['id'] ?? null,
                'name' => $hr['department']['name'] ?? null,
            ] : null,
            'career' => isset($hr['career']) ? [
                'id' => $hr['career']['id'] ?? null,
                'name' => $hr['career']['name'] ?? null,
            ] : null,

            'experiences' => !empty($hr['experiences'])
            ? ExperienceResource::collection(collect($hr['experiences']))
            : [],

            'avatar' => $hr['media'][0]['original_url'] ?? null,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
