<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use App\Enums\UserType;
use App\Models\User;
use App\Models\Wallet;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required|numeric|gt:0',
            'payer' => 'required|integer',
            'payee' => 'required|integer',
        ];
    }

    /**
    * Configure the validator instance.
    *
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $payer = User::findOrFail($this->payer);
            $walletPayer = Wallet::where('user_id', '=', $this->payer)->firstOrFail();

            if (!$this->payerIsValid($payer)) {
                $validator->errors()->add('payer', 'The payer must not be a shopkeeper!');
            }
            if ($walletPayer->value < $this->value) {
                $validator->errors()->add('payer', 'The payer must have the value in the wallet!');
            }
            if ($this->payer == $this->payee) {
                $validator->errors()->add('payer', 'The payer must be different from the payee!');
            }
        });
    }

    /**
    * Check if the user is valid
    *
    * @param  \App\Models\User  $user
    * @return void
    */
    private function payerIsValid(User $payer) {
        $userType = User::documentToUserType($payer->document);
        if($userType == UserType::Commom) {
            return true;
        }
        return false;
    }
}
