# User

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**polar_user_id** | **int** | User&#x27;s id in Polar database | [optional] 
**member_id** | **string** | User&#x27;s identifier in partner&#x27;s database | [optional] 
**registration_date** | [**\DateTime**](\DateTime.md) | Timestamp marked when ACCEPTED | [optional] 
**first_name** | **string** | User&#x27;s first name | [optional] 
**last_name** | **string** | User&#x27;s surname | [optional] 
**birthdate** | **string** | User&#x27;s birthdate as YYYY-MM-DD | [optional] 
**gender** | **string** | User&#x27;s sex | [optional] 
**weight** | **float** | User&#x27;s weight in kg | [optional] 
**height** | **float** | Users height in centimeters | [optional] 
**field** | [**\Coachbox\Services\Polar\Models\UserExtraInfo[]**](UserExtraInfo.md) | List containing answers given by the user to a number of partner-specific questions. Extra-info is null if there are no required fields defined by the partner. | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)

