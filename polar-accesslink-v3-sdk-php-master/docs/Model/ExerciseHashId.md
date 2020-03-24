# ExerciseHashId

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Hashed id of the trainining session | [optional] 
**upload_time** | **string** | Time of the transfer from wrist unit to Polar database | [optional] 
**polar_user** | **string** | Absolute link to Polar user owning the training | [optional] 
**device** | **string** | Polar product used in training | [optional] 
**start_time** | **string** | Start time of the training session in local time | [optional] 
**duration** | **string** | The duration of the training session as specified in ISO8601 | [optional] 
**calories** | **int** | Expended calories during training in kilocalories | [optional] 
**distance** | **float** | Distance in meters travelled during training | [optional] 
**heart_rate** | [**\Coachbox\Services\Polar\Models\HeartRate**](HeartRate.md) |  | [optional] 
**training_load** | **float** | Training load effect to user | [optional] 
**sport** | **string** | Sport name | [optional] 
**has_route** | **bool** | Boolean indicating if the exercise has route data | [optional] 
**club_id** | **int** | Has value if the exercise is from \&quot;Flow For Club\&quot;, otherwise not printed. Value -1 indicates that there were errors finding the club | [optional] 
**club_name** | **string** | Has value if the exercise is from \&quot;Flow For Club\&quot;, otherwise not printed. Value \&quot;Ambiguous club location. Please contact support.\&quot; is printed in case of error (and the club-id is -1). | [optional] 
**detailed_sport_info** | **string** | String containing the name of a Polar Flow-compatible sport, if one is set for the exercise. | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)

