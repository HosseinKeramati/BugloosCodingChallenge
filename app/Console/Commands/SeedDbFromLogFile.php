<?php

namespace App\Console\Commands;

use App\Models\MicroserviceLog;
use Illuminate\Console\Command;

class SeedDbFromLogFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-db-from-log-file {public_path=logs.txt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database using sample logs file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $path = $this->argument('public_path');

        if(!file_exists(public_path($path))) {

            $this->error('Logs file not found!');
            die;

        }

        $logsFile = file_get_contents(public_path($path));

        $count = SeedDbFromLogFile::newLogFileEntry($logsFile);

        $this->info("$count record(s) added to database successfully!");

    }

    /**
     * Convert text format log to array
     * 
     * @param  string $logsFile
     * @return integer          
     */
    public static function newLogFileEntry($logsFile)
    {
        $logs = explode("\r\n", $logsFile);
        return SeedDbFromLogFile::parseLogs($logs);

    }

    /**
     * Parse each line of microservice's logs
     * 
     * @param  array $logs
     * @return integer      
     */
    public static function parseLogs($logs)
    {
        $counter = 0;
        foreach ($logs as $log) {
            preg_match('/([a-z]+-[a-z]+) - \[(.+)\] "(.+)" (\d+)/', $log, $matches,);
            $serviceName = $matches[1];
            $dateTime = SeedDbFromLogFile::parseDateTime($matches[2]);
            $requestLine = $matches[3];
            $statusCode = $matches[4];
            
            SeedDbFromLogFile::insertIntoDatabse($serviceName,$dateTime,$requestLine,$statusCode);
            $counter++;

        }

        return $counter;
    }

    /**
     * Insert logs into database
     * 
     * @param  string $serviceName
     * @param  string $dateTime   
     * @param  string $requestLine
     * @param  integer $statusCode 
     * @return boolean             
     */
    public static function insertIntoDatabse($serviceName, $dateTime, $requestLine, $statusCode)
    {
        $newLog = new MicroserviceLog;
        $newLog->service_name = $serviceName;
        $newLog->created_at = $dateTime;
        $newLog->request_line = $requestLine;
        $newLog->status_code = $statusCode;
        $newLog->date = explode(' ', $dateTime)[0];
        $newLog->save();

        return true;

    }

    /**
     * Parse datetime string
     * 
     * @param  string $dateTime
     * @return string          
     */
    public static function parseDateTime($dateTime)
    {
        $inputDate = strstr($dateTime, ':', true);
        $convetionalDate = SeedDbFromLogFile::convertDate($inputDate);

        $time = substr($dateTime, 12);

        return "$convetionalDate $time";
    }

    /**
     * Convert date style
     * 
     * @param  string $date
     * @return string      
     */
    public static function convertDate($date)
    {
        $dateArray = explode('/', $date);
        $day = $dateArray[0];
        $month = SeedDbFromLogFile::convertMonthToNumeric($dateArray[1]);

        if($month < 10){
            $month = "0$month";
        }
        $year = $dateArray[2];

        return "$year-$month-$day";

    }

    /**
     * Convert month name to number
     * 
     * @param  string $month
     * @return integer       
     */
    public static function convertMonthToNumeric($month)
    {
        $monthsName=[
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        return array_search($month, $monthsName) + 1;
    }
}
