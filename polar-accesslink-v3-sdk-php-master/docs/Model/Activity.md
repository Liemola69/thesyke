# Activity

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** | Activity summary id | [optional] 
**polar_user** | **string** | Absolute link to user owning the activity | [optional] 
**transaction_id** | **int** | Id of the activity-transaction this training was transferred in | [optional] 
**date** | **string** | Date when activity summary was recorded, in format YYYY-MM-DD | [optional] 
**created** | **string** | The time activity summary was created in Accesslink, in format YYYY-MM-DDTHH:mm:ss.SSS | [optional] 
**calories** | **int** | Total daily calories in kilo calories including BMR | [optional] 
**active_calories** | **int** | Total daily calories not including BMR. Precise calculation requires that user&#x27;s physical data is entered into Polar Flow | [optional] 
**duration** | **string** | The time interval as specified in ISO 8601 | [optional] 
**active_steps** | **int** | You could consider this as a kind of activity unit. If you take one step the active-steps should increase by one and any activity comparable to one physical step would also increase the number by one | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)

