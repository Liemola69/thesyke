# Coachbox\Services\Polar\PullNotificationsApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**callList**](PullNotificationsApi.md#callList) | **GET** /v3/notifications | List

# **callList**
> \Coachbox\Services\Polar\Models\AvailableUserDatas callList()

List

Get list of available exercises and activities for users

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure HTTP basic authorization: Basic
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Coachbox\Services\Polar\API\PullNotificationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->callList();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PullNotificationsApi->callList: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Coachbox\Services\Polar\Models\AvailableUserDatas**](../Model/AvailableUserDatas.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json, application/xml

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

