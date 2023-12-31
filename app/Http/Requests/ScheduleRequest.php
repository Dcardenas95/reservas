<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;
use App\Business\OpeningHourChecker;
use App\Models\OpeningHour;

class ScheduleRequest extends FormRequest
{
    use ManagesReservationRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from.date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'from.time' => 'required|date_format:H:i',
            'staff_user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ];
    }

}
