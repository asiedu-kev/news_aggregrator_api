<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\Account\AccountResource;
use App\Models\Account;

class AccountController extends ApiController
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $this->authorize('update', $account);
        $account->update($request->all());
        return new AccountResource($account);
    }
}
