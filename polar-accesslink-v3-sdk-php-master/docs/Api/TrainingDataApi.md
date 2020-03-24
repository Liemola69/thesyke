# Coachbox\Services\Polar\TrainingDataApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**commitExerciseTransaction**](TrainingDataApi.md#commitExerciseTransaction) | **PUT** /v3/users/{user-id}/exercise-transactions/{transaction-id} | Commit transaction
[**createExerciseTransaction**](TrainingDataApi.md#createExerciseTransaction) | **POST** /v3/users/{user-id}/exercise-transactions | Create transaction
[**getAvailableSamples**](TrainingDataApi.md#getAvailableSamples) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/samples | Get available samples
[**getExerciseSummary**](TrainingDataApi.md#getExerciseSummary) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id} | Get exercise summary
[**getFit**](TrainingDataApi.md#getFit) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/fit | Get FIT (beta)
[**getGpx**](TrainingDataApi.md#getGpx) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/gpx | Get GPX
[**getHeartRateZones**](TrainingDataApi.md#getHeartRateZones) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/heart-rate-zones | Get heart rate zones
[**getSamples**](TrainingDataApi.md#getSamples) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/samples/{type-id} | Get samples
[**getTcx**](TrainingDataApi.md#getTcx) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id}/exercises/{exercise-id}/tcx | Get TCX
[**listExercises**](TrainingDataApi.md#listExercises) | **GET** /v3/users/{user-id}/exercise-transactions/{transaction-id} | List exercises

# **commitExerciseTransaction**
> commitExerciseTransaction($transaction_id, $user_id)

Commit transaction

After successfully retrieving training session data within a transaction, partners are expected to commit the transaction.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $apiInstance->commitExerciseTransaction($transaction_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->commitExerciseTransaction: ', $e->getMessage(), PHP_EOL;
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

# **createExerciseTransaction**
> \Coachbox\Services\Polar\Models\TransactionLocation createExerciseTransaction($user_id)

Create transaction

Check for new training data and create a new transaction if found.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->createExerciseTransaction($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->createExerciseTransaction: ', $e->getMessage(), PHP_EOL;
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

# **getAvailableSamples**
> \Coachbox\Services\Polar\Models\Samples getAvailableSamples($user_id, $transaction_id, $exercise_id)

Get available samples

Retrieve list of links to available samples in training session

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getAvailableSamples($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getAvailableSamples: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Samples**](../Model/Samples.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getExerciseSummary**
> \Coachbox\Services\Polar\Models\Exercise getExerciseSummary($user_id, $transaction_id, $exercise_id)

Get exercise summary

Retrieve training session summary data

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getExerciseSummary($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getExerciseSummary: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Exercise**](../Model/Exercise.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getFit**
> string getFit($user_id, $transaction_id, $exercise_id)

Get FIT (beta)

Retrieve exercise in FIT format. **Note!** This interface is in beta phase. If there is anything we can help you with or you want to give us feedback, please contact [Support](#support).

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getFit($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getFit: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

**string**

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getGpx**
> string getGpx($user_id, $transaction_id, $exercise_id)

Get GPX

Retrieve training session summary data in GPX format

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getGpx($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getGpx: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

**string**

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/gpx+xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getHeartRateZones**
> \Coachbox\Services\Polar\Models\Zones getHeartRateZones($user_id, $transaction_id, $exercise_id)

Get heart rate zones

Retrieve heart rate zones in training session

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getHeartRateZones($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getHeartRateZones: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Zones**](../Model/Zones.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getSamples**
> \Coachbox\Services\Polar\Models\Sample getSamples($type_id, $user_id, $transaction_id, $exercise_id)

Get samples

Retrieve sample data of given type

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$type_id = "B"; // string | Sample type id
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getSamples($type_id, $user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getSamples: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **type_id** | **string**| Sample type id |
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Sample**](../Model/Sample.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getTcx**
> string getTcx($user_id, $transaction_id, $exercise_id)

Get TCX

Retrieve exercise in TCX format

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 56; // int | User identifier
$transaction_id = 56; // int | Transaction identifier
$exercise_id = 56; // int | Exercise identifier

try {
    $result = $apiInstance->getTcx($user_id, $transaction_id, $exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->getTcx: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**| User identifier |
 **transaction_id** | **int**| Transaction identifier |
 **exercise_id** | **int**| Exercise identifier |

### Return type

**string**

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/vnd.garmin.tcx+xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listExercises**
> \Coachbox\Services\Polar\Models\Exercises listExercises($transaction_id, $user_id)

List exercises

After successfully initiating a transaction, training sessions included within it can be retrieved with the provided transactionId.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\TrainingDataApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 789; // int | Transaction identifier
$user_id = 56; // int | User identifier

try {
    $result = $apiInstance->listExercises($transaction_id, $user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TrainingDataApi->listExercises: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**| Transaction identifier |
 **user_id** | **int**| User identifier |

### Return type

[**\Coachbox\Services\Polar\Models\Exercises**](../Model/Exercises.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

