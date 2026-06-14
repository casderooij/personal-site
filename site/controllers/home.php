<?php

return function ($page, $routeYear = null, $routeMonth = null) {
    if ($routeYear && $routeMonth) {
        $timestamp = strtotime("$routeYear-$routeMonth-01");
    } else {
        $timestamp = time();
    }

    $year  = date('Y', $timestamp);
    $month = date('m', $timestamp);

    $prevMonthTime = strtotime("-1 month", strtotime("$year-$month-01"));
    $nextMonthTime = strtotime("+1 month", strtotime("$year-$month-01"));

    $prevLink = $page->url() . '/' . date('y-m', $prevMonthTime);
    $nextLink = $page->url() . '/' . date('y-m', $nextMonthTime);

    $sketchesPage = page('sketches');
    $sketches     = $sketchesPage
        ? $sketchesPage->children()->unlisted()->filter(function ($child) use ($year, $month) {
            return $child->date()->toDate('Y-m') === "$year-$month";
        })
        : new Kirby\Cms\Pages();

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
    $grid = [];

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);

        $daySketch = $sketches->filter(function ($item) use ($dateString) {
            return $item->date()->toDate('Y-m-d') === $dateString;
        })->first();

        $grid[] = [
            'day'    => $day,
            'date'   => $dateString,
            'sketch' => $daySketch
        ];
    }

    return [
        'grid'          => $grid,
        'currentMonth'  => date('F Y', $timestamp),
        'prevLink'      => $prevLink,
        'prevMonth'     => date('F', $prevMonthTime),
        'nextLink'      => $nextLink,
        'nextMonth'     => date('F', $nextMonthTime),
    ];
};
