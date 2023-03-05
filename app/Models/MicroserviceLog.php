<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicroserviceLog extends Model
{
    use HasFactory;

    /**
     * Check filter inputs
     * 
     * @param  array $queryParameters
     * @return boolean                  
     */
    public static function logsCountHasWrongFilterInput($queryParameters)
    {
        if(count($queryParameters)) {
            foreach (array_keys($queryParameters) as $filterKey) {
                
                if (array_search($filterKey, ['serviceNames','statusCode','startDate','endDate']) === false) {
                    
                    return true;
                }
            }
        }
        return false;

    }

    /**
     * Logs count
     * 
     * @param  array $queryParameters
     * @return integer
     */
    public static function logsCountWithFilters($queryParameters)
    {
        $microservicelogs = MicroserviceLog::select();

        if(is_array($queryParameters) && count($queryParameters) > 0){

            foreach ($queryParameters as $queryParameterKey => $queryParameterValue) {
                    if(!$queryParameterValue){
                        continue;
                    }

                    switch ($queryParameterKey) {
                        case 'serviceNames':

                            $microservicelogs->whereIn('service_name', explode(',', $queryParameterValue));

                            break;

                        case 'statusCode':

                            $microservicelogs->where('status_code', $queryParameterValue);

                            break;

                        case 'startDate':

                            $microservicelogs->where('date', '>=', $queryParameterValue);

                            break;

                        case 'endDate':

                            $microservicelogs->where('date', '<=', $queryParameterValue);

                            break;
                    }   

                }

        }

        return $microservicelogs->count();
    }



}
