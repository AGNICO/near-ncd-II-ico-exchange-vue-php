<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface NearService
{
    public function getAccount($accountId);

    public function getAllOffers($contractId, Request $request);

    public function getOffer($contractId, Request $request);

    public function getFTMetadata($contractId);

    public function getFTTotalSupply($contractId);

    public function getStorageBalance($contractId, $accountId);

    public function getFTBalance($contractId, $accountId);
}