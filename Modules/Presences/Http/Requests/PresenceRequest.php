<?php

namespace Modules\Presences\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Presences\Entities\Presences;

class PresenceRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:in,out',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('type') == 'out') {
                $presenceIn = Presences::where('user_id', auth()->user()->id)
                ->where('type', 'in')
                ->orderBy('created_at', 'desc')
                ->first();

                if (!$presenceIn) {
                    $validator->errors()->add('type', 'Tidak dapat melakukan check log tanpa check in sebelumnya.');
                }
            }

            if ($this->input('type') == 'in') {
                $workdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'
                ];
                $currentDay = strtolower(now()->format('l'));

                if (!in_array($currentDay, $workdays)) {
                    $validator->errors()->add('type', 'Presensi in hanya boleh dilakukan pada hari Senin sampai Jumat.');
                }

                $currentHour = now()->format('H:i:s');
                if ($currentHour < '08:00:00' || $currentHour > '16:00:00') {
                    $validator->errors()->add('type', 'Presensi in hanya boleh dilakukan antara jam 08:00 dan 16:00.');
                }
            }
        });
    }
}
