<?php

return function ($page) {
    // 1. Fetch sketches (includes both listed and unlisted children)
    $sketchesPage = page('sketches');
    $allSketches  = $sketchesPage ? $sketchesPage->children() : new \Kirby\Cms\Pages();
    $sketchesByDate = [];

    foreach ($allSketches as $sketch) {
        // Use field or fallback to page slug if date field is empty
        $dateValue = $sketch->date()->isNotEmpty()
            ? $sketch->date()->toDate('Y-m-d')
            : $sketch->slug();

        if ($dateValue) {
            $sketchesByDate[$dateValue] = $sketch;
        }
    }

    // 2. Determine target week (using URL parameter ?week=YYYY-Www, falling back to current date)
    $currentDate = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
    $weekParam   = get('week');

    if ($weekParam && preg_match('/^([0-9]{4})-W([0-9]{2})$/', $weekParam, $matches)) {
        $year = (int)$matches[1];
        $week = (int)$matches[2];
    } else {
        $year = (int)$currentDate->format('o'); // ISO-8601 week-numbering year
        $week = (int)$currentDate->format('W'); // ISO-8601 week number
    }

    // 3. Set reference point to Monday of that week
    $dateTime = new DateTime();
    $dateTime->setISODate($year, $week, 1);

    // 4. Populate 7 days for the calendar columns
    $days = [];
    for ($i = 0; $i < 7; $i++) {
        $dateClone  = clone $dateTime;
        $dateClone->modify("+$i days");
        $dateString = $dateClone->format('Y-m-d');

        $days[] = [
            'date'       => $dateClone,
            'dateString' => $dateString,
            'dayName'    => $dateClone->format('D'), // e.g. "Mon"
            'dayNum'     => $dateClone->format('j'), // e.g. "10"
            'isToday'    => $dateString === $currentDate->format('Y-m-d'),
            'sketch'     => $sketchesByDate[$dateString] ?? null
        ];
    }

    // 5. Generate semantic pagination links
    $prevWeekDate = clone $dateTime;
    $prevWeekDate->modify('-1 week');
    $prevWeekUrl = url($page->url(), ['query' => ['week' => $prevWeekDate->format('o-\WW')]]);

    $nextWeekDate = clone $dateTime;
    $nextWeekDate->modify('+1 week');
    $nextWeekUrl = url($page->url(), ['query' => ['week' => $nextWeekDate->format('o-\WW')]]);

    $todayUrl = url($page->url(), ['query' => ['week' => $currentDate->format('o-\WW')]]);

    // 6. Generate Month Title (e.g. "June 2026" or "Jun – Jul 2026")
    $firstDay = $days[0]['date'];
    $lastDay  = $days[6]['date'];
    if ($firstDay->format('F Y') === $lastDay->format('F Y')) {
        $weekTitle = $firstDay->format('F Y');
    } elseif ($firstDay->format('Y') === $lastDay->format('Y')) {
        $weekTitle = $firstDay->format('M') . ' – ' . $lastDay->format('M Y');
    } else {
        $weekTitle = $firstDay->format('M Y') . ' – ' . $lastDay->format('M Y');
    }

    return [
        'days'        => $days,
        'weekTitle'   => $weekTitle,
        'prevWeekUrl' => $prevWeekUrl,
        'nextWeekUrl' => $nextWeekUrl,
        'todayUrl'    => $todayUrl,
        'currentWeek' => $year . '-W' . str_pad($week, 2, '0', STR_PAD_LEFT)
    ];
};
