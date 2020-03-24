# Coachbox\Services\Polar\PhysicalInfoApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**commitPhysicalInfoTransaction**](PhysicalInfoApi.md#commitPhysicalInfoTransaction) | **PUT** /v3/users/{user-id}/physical-information-transactions/{transaction-id} | Commit transaction
[**createPhysicalInfoTransaction**](PhysicalInfoApi.md#createPhysicalInfoTransaction) | **POST** /v3/users/{user-id}/physical-information-transactions | Create transaction
[**getPhysicalInfo**](PhysicalInfoApi.md#getPhysicalInfo) | **GET** /v3/users/{user-id}/physical-information-transactions/{transaction-id}/physical-informations/{physical-info-id} | Get physical info
[**listPhysicalInfos**](PhysicalInfoApi.md#listPhysicalInfos) | **GET** /v3/users/{user-id}/physical-information-transactions/{transaction-id} | List physical infos

# **commitPhysicalInfoTransaction**
> commitPhysicalInfoTransaction($transaction_id, $user_id)

Commit transaction

After successfully retrieving physical information within a transaction, partners are expected to commit the transaction.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\PhysicalInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $apiInstance->commitPhysicalInfoTransaction($transaction_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling PhysicalInfoApi->commitPhysicalInfoTransaction: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**| Transaction identifier |
 **user_id** | **int**| User identifier |

### Return type

void (empty response body)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createPhysicalInfoTransaction**
> \Coachbox\Services\Polar\Models\TransactionLocation createPhysicalInfoTransaction($user_id)

Create transaction

Initiate physical info transaction. Check for new physical info and create a new transaction if found.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\PhysicalInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->createPhysicalInfoTransaction($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PhysicalInfoApi->createPhysicalInfoTransaction: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |

### Return type

[**\Coachbox\Services\Polar\Models\TransactionLocation**](../Model/TransactionLocation.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getPhysicalInfo**
> \Coachbox\Services\Polar\Models\PhysicalInformation getPhysicalInfo($user_id, $transaction_id, $physical_info_id)

Get physical info

Get physical info entity data

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\PhysicalInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$physical_info_id = 56; // int | Physical information identifier

try {
    $result = $apiInstance->getPhysicalInfo($user_id, $transaction_id, $physical_info_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PhysicalInfoApi->getPhysicalInfo: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **physical_info_id** | **int**| Physical information identifier |

### Return type

[**\Coachbox\Services\Polar\Models\PhysicalInformation**](../Model/PhysicalInformation.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listPhysicalInfos**
> \Coachbox\Services\Polar\Models\PhysicalInformations listPhysicalInfos($transaction_id, $user_id)

List physical infos

List new physical info data. After successfully initiating a transaction, physical infos included within it can be retrieved with the provided transactionId.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\PhysicalInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->listPhysicalInfos($transaction_id, $user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PhysicalInfoApi->listPhysicalInfos: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**| Transaction identifier |
 **user_id** | **int**| User identifier |

### Return type

[**\Coachbox\Services\Polar\Models\PhysicalInformations**](../Model/PhysicalInformations.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

