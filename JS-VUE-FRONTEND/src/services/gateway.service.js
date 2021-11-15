import axios from 'axios';
//import authHeader from './auth-header';

class GatewayService {
    getNearAccount(accountId) {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/account/' + accountId);
    }

    getNearPrice() {
        return axios.get(process.env.VUE_APP_COINGECKO_API_URL);
    }

    getAllOffers(from_index = 0, limit = 20) {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/' + process.env.VUE_APP_ICO_CONTRACT +'/get_all_offers', {
            params: {
                from_index: from_index,
                limit: limit
            }
        });
    }

    getOffer(near_price) {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/' + process.env.VUE_APP_ICO_CONTRACT + '/get_offer', {
            params: {
                near_price: near_price
            }
        });
    }

    getStorageBalance(accountId) {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/' + process.env.VUE_APP_ICO_CONTRACT + '/get_storage_balance/' + accountId);
    }

    getFTBalance(accountId) {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/' + process.env.VUE_APP_ICO_CONTRACT + '/get_ft_balance/' + accountId);
    }

    getFTMetadata() {
        return axios.get(process.env.VUE_APP_GATEWAY_API_URL + '/near/' + process.env.VUE_APP_ICO_CONTRACT + '/get_ft_metadata');
    }
}

export default new GatewayService();