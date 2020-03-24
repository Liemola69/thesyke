# Coachbox\Services\Polar\DailyActivityApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**commitActivityTransaction**](DailyActivityApi.md#commitActivityTransaction) | **PUT** /v3/users/{user-id}/activity-transactions/{transaction-id} | Commit transaction
[**createActivityTransaction**](DailyActivityApi.md#createActivityTransaction) | **POST** /v3/users/{user-id}/activity-transactions | Create transaction
[**getActivitySummary**](DailyActivityApi.md#getActivitySummary) | **GET** /v3/users/{user-id}/activity-transactions/{transaction-id}/activities/{activity-id} | Get activity summary
[**getStepSamples**](DailyActivityApi.md#getStepSamples) | **GET** /v3/users/{user-id}/activity-transactions/{transaction-id}/activities/{activity-id}/step-samples | Get step samples
[**getZoneSamples**](DailyActivityApi.md#getZoneSamples) | **GET** /v3/users/{user-id}/activity-transactions/{transaction-id}/activities/{activity-id}/zone-samples | Get zone samples
[**listActivities**](DailyActivityApi.md#listActivities) | **GET** /v3/users/{user-id}/activity-transactions/{transaction-id} | List activities

# **commitActivityTransaction**
> commitActivityTransaction($transaction_id, $user_id)

Commit transaction

After successfully retrieving activity summary data within a transaction, partners are expected to commit the transaction.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $apiInstance->commitActivityTransaction($transaction_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->commitActivityTransaction: ', $e->getMessage(), PHP_EOL;
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

# **createActivityTransaction**
> \Coachbox\Services\Polar\Models\TransactionLocation createActivityTransaction($user_id)

Create transaction

Initiate activity transaction. Check for new activity summaries and create a new transaction if found.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->createActivityTransaction($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->createActivityTransaction: ', $e->getMessage(), PHP_EOL;
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

# **getActivitySummary**
> \Coachbox\Services\Polar\Models\Activity getActivitySummary($user_id, $transaction_id, $activity_id)

Get activity summary

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$activity_id = 56; // int | Activity summary identifier

try {
    $result = $apiInstance->getActivitySummary($user_id, $transaction_id, $activity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->getActivitySummary: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **activity_id** | **int**| Activity summary identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Activity**](../Model/Activity.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getStepSamples**
> \Coachbox\Services\Polar\Models\ActivityStepSamples getStepSamples($user_id, $transaction_id, $activity_id)

Get step samples

Get activity step samples. Example data can be seen from [appendix](#activity-step-time-series).

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$activity_id = 56; // int | Activity summary identifier

try {
    $result = $apiInstance->getStepSamples($user_id, $transaction_id, $activity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->getStepSamples: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **activity_id** | **int**| Activity summary identifier |

### Return type

[**\Coachbox\Services\Polar\Models\ActivityStepSamples**](../Model/ActivityStepSamples.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneSamples**
> \Coachbox\Services\Polar\Models\ActivityZoneSamples getZoneSamples($user_id, $transaction_id, $activity_id)

Get zone samples

Get activity zone samples. Example data can be seen from [appendix](#activity-zone-time-series).

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$activity_id = 56; // int | Activity summary identifier

try {
    $result = $apiInstance->getZoneSamples($user_id, $transaction_id, $activity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->getZoneSamples: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **activity_id** | **int**| Activity summary identifier |

### Return type

[**\Coachbox\Services\Polar\Models\ActivityZoneSamples**](../Model/ActivityZoneSamples.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listActivities**
> \Coachbox\Services\Polar\Models\ActivityLogs listActivities($transaction_id, $user_id)

List activities

List new activity data. After successfully initiating a transaction, activity summaries included within it can be retrieved with the provided transactionId.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\DailyActivityApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->listActivities($transaction_id, $user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DailyActivityApi->listActivities: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**| Transaction identifier |
 **user_id** | **int**| User identifier |

### Return type

[**\Coachbox\Services\Polar\Models\ActivityLogs**](../Model/ActivityLogs.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

