# Coachbox\Services\Polar\WebhooksApi

All URIs are relative to *https://www.polaraccesslink.com/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createWebhook**](WebhooksApi.md#createWebhook) | **POST** /v3/webhooks | Create webhook
[**deleteWebhook**](WebhooksApi.md#deleteWebhook) | **DELETE** /v3/webhooks/{webhook-id} | Delete webhook
[**getWebhook**](WebhooksApi.md#getWebhook) | **GET** /v3/webhooks | Get webhook
[**updateWebhook**](WebhooksApi.md#updateWebhook) | **PATCH** /v3/webhooks/{webhook-id} | Update webhook

# **createWebhook**
> \Coachbox\Services\Polar\Models\CreatedWebhook createWebhook($body)

Create webhook

Create new webhook.  When creating webhook the Accesslink sends a ping message to the url in request body. The ping message must be answered with 200 OK or otherwise the webhook is not created.  **Note!** Save the *signature_secret_key* from response since this is the only chance to get it.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure HTTP basic authorization: Basic
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Coachbox\Services\Polar\API\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Coachbox\Services\Polar\Models\WebhookRequest(); // \Coachbox\Services\Polar\Models\WebhookRequest | Webhook to create.

try {
    $result = $apiInstance->createWebhook($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->createWebhook: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Coachbox\Services\Polar\Models\WebhookRequest**](../Model/WebhookRequest.md)| Webhook to create. |

### Return type

[**\Coachbox\Services\Polar\Models\CreatedWebhook**](../Model/CreatedWebhook.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteWebhook**
> deleteWebhook($webhook_id)

Delete webhook

Delete webhook by id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure HTTP basic authorization: Basic
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Coachbox\Services\Polar\API\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook_id = 56; // int | Webhook id to delete

try {
    $apiInstance->deleteWebhook($webhook_id);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->deleteWebhook: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **webhook_id** | **int**| Webhook id to delete |

### Return type

void (empty response body)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getWebhook**
> \Coachbox\Services\Polar\Models\WebhookInfo getWebhook()

Get webhook

Returns created webhook if exists.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure HTTP basic authorization: Basic
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Coachbox\Services\Polar\API\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getWebhook();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->getWebhook: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Coachbox\Services\Polar\Models\WebhookInfo**](../Model/WebhookInfo.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateWebhook**
> \Coachbox\Services\Polar\Models\WebhookInfo updateWebhook($body, $webhook_id)

Update webhook

Edit webhook event types and/or url.  When updating webhook url the Accesslink sends a ping message to the new address. The ping message must be answered with 200 OK or otherwise the webhook is not updated.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure HTTP basic authorization: Basic
$config = Coachbox\Services\Polar\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Coachbox\Services\Polar\API\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Coachbox\Services\Polar\Models\WebhookPatch(); // \Coachbox\Services\Polar\Models\WebhookPatch | New value(s) for events and/or url.
$webhook_id = 56; // int | Webhook id to update

try {
    $result = $apiInstance->updateWebhook($body, $webhook_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->updateWebhook: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Coachbox\Services\Polar\Models\WebhookPatch**](../Model/WebhookPatch.md)| New value(s) for events and/or url. |
 **webhook_id** | **int**| Webhook id to update |

### Return type

[**\Coachbox\Services\Polar\Models\WebhookInfo**](../Model/WebhookInfo.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

