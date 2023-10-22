<?php

test('1 +1 to be 2', function () {
    $result = 1 + 1;
    expect($result)->toBe(2);
});
