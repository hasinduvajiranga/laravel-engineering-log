<?php

declare(strict_types=1);
use App\Daily\DailyConcept;

it('implements today concept', function () {
    expect((new DailyConcept)->execute())->toBeString();
});
