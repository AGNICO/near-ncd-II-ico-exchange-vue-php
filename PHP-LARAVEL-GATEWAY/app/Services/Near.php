<?php

namespace App\Services;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Contracts\NearService;

class Near implements NearService
{
    /**
     * The service config
     *
     * @return string
     */
    private $config;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get NEAR account info
     *
     * @return string
     */
    public function getAccount($accountId)
    {
        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'view_account',
                'finality' => 'final',
                'account_id' => $accountId
            ]
        ]);

        $response = Http::withBody($body, 'application/json')->post($this->config['rpc_node']);

        return $response->json();
    }

    /**
     * Get ICO contract offers
     *
     * @return string
     */
    public function getAllOffers($contractId, Request $request)
    {
        $params = json_encode([
            'from_index' => (int) $request->from_index ?: 0,
            'limit' => (int) $request->limit ?: 20,
        ]);

        $tokenSpec = json_decode($this->getFTMetadata($contractId)->getData());

        $ftTotalSupply = json_decode($this->getFTTotalSupply($contractId)->getData());
        $tokenSpec->total_supply = (int) $ftTotalSupply;

        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "get_all_offers",
                'args_base64' => base64_encode($params)
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        $offers = json_decode(implode(array_map("chr", $response)));

        $result = null;
        foreach ($offers as $offer) {
            $result[] = [
                'token_spec' => $tokenSpec,
                'near_price' => $offer[0],
                'available_supply' => $offer[1],
            ];
        }

        return response()->json($result);
    }

    /**
     * Get ICO contract offer based on near price
     *
     * @return string
     */
    public function getOffer($contractId, Request $request)
    {
        $params = json_encode([
            'near_price' => (int) $request->near_price ?: 0
        ]);

        $tokenSpec = json_decode($this->getFTMetadata($contractId)->getData());

        $ftTotalSupply = json_decode($this->getFTTotalSupply($contractId)->getData());
        $tokenSpec->total_supply = (int) $ftTotalSupply;

        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "get_offer",
                'args_base64' => base64_encode($params)
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        $offer = json_decode(implode(array_map("chr", $response)));

        $offer = [
            'token_spec' => $tokenSpec,
            'near_price' => (int) $request->near_price,
            'available_supply' => $offer,
        ];

        return response()->json($offer);
    }

    /**
     * Get ICO token Metadata
     *
     * @return string
     */
    public function getFTMetadata($contractId)
    {
        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "ft_metadata",
                'args_base64' => ""
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        $response = json_decode(implode(array_map("chr", $response)));
        $response->contract_id = $contractId;

        return response()->json(json_encode($response));
    }

    /**
     * Get ICO token total supply
     *
     * @return string
     */
    public function getFTTotalSupply($contractId)
    {
        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "ft_total_supply",
                'args_base64' => ""
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        return response()->json(implode(array_map("chr", $response)));
    }

    /**
     * Get buyer account FT storage balance
     *
     * @return string
     */
    public function getStorageBalance($contractId, $accountId)
    {
        $params = json_encode([
            'account_id' => $accountId
        ]);

        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "storage_balance_of",
                'args_base64' => base64_encode($params)
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        return response()->json(implode(array_map("chr", $response)));
    }

    /**
     * Get account FT balance
     *
     * @return string
     */
    public function getFTBalance($contractId, $accountId)
    {
        $params = json_encode([
            'account_id' => $accountId
        ]);

        $body = json_encode([
            'jsonrpc' => $this->config['jsonrpc'],
            'id' => $this->config['id'],
            'method' => 'query',
            'params' => [
                'request_type' => 'call_function',
                'finality' => 'final',
                'account_id' => $contractId,
                "method_name" => "ft_balance_of",
                'args_base64' => base64_encode($params)
            ]
        ]);

        $response = Http::withBody($body, 'application/json')
            ->post($this->config['rpc_node'])
            ->json()['result']['result'];

        return response()->json(implode(array_map("chr", $response)));
    }
}