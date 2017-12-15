<?php

class TimeRangeCreator
{
    public function __construct()
    {
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function createTimeRange(): array
    {
        $timeRangeFinished = [];
        $timeRange = $this->databaseDataManager->getTimeRange();
        if ($timeRange)
        {
            foreach ($timeRange as $value)
            {
                foreach ($value as $time)
                {
                    $timeRangeFinished[] = $time;
                }
            }
        }
        else
        {
            $date = new DateTime();
            $timeRangeFinished[] = $date->format('Y-m-d H:i:s');
        }

        return $timeRangeFinished;
    }
}