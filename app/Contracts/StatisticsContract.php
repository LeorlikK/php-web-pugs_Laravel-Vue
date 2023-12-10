<?php

namespace App\Contracts;

interface StatisticsContract
{
    function usersStatistics(): array;
    function mediaStatistics(): array;
    function newsStatistics(): array;
    function commentsStatistics(): array;
    function fullStatistics(): array;
}
