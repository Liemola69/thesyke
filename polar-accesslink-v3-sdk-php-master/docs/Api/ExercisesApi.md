# Coachbox\Services\Polar\ExercisesApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getExerciseFitWithoutTransaction**](ExercisesApi.md#getExerciseFitWithoutTransaction) | **GET** /v3/exercises/{exerciseId}/fit | Get exercise FIT
[**getExerciseWithoutTransaction**](ExercisesApi.md#getExerciseWithoutTransaction) | **GET** /v3/exercises/{exerciseId} | Get exercise
[**listExercisesWithoutTransaction**](ExercisesApi.md#listExercisesWithoutTransaction) | **GET** /v3/exercises | List exercises

# **getExerciseFitWithoutTransaction**
> string getExerciseFitWithoutTransaction($exercise_id)

Get exercise FIT

FIT file for users exercise.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\ExercisesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$exercise_id = "exercise_id_example"; // string | Hashed exercise id.

try {
    $result = $apiInstance->getExerciseFitWithoutTransaction($exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExercisesApi->getExerciseFitWithoutTransaction: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **exercise_id** | **string**| Hashed exercise id. |

### Return type

**string**

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getExerciseWithoutTransaction**
> \Coachbox\Services\Polar\Models\ExerciseHashId getExerciseWithoutTransaction($exercise_id)

Get exercise

Get users exercise using hashed id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\ExercisesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$exercise_id = "exercise_id_example"; // string | Hashed exercise id.

try {
    $result = $apiInstance->getExerciseWithoutTransaction($exercise_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExercisesApi->getExerciseWithoutTransaction: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **exercise_id** | **string**| Hashed exercise id. |

### Return type

[**\Coachbox\Services\Polar\Models\ExerciseHashId**](../Model/ExerciseHashId.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listExercisesWithoutTransaction**
> \Coachbox\Services\Polar\Models\ExercisesHashId listExercisesWithoutTransaction()

List exercises

List users exercises available in Accesslink.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: OAuth2
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Coachbox\Services\Polar\API\ExercisesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listExercisesWithoutTransaction();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ExercisesApi->listExercisesWithoutTransaction: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Coachbox\Services\Polar\Models\ExercisesHashId**](../Model/ExercisesHashId.md)

### Authorization

[OAuth2](../../README.md#OAuth2)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

