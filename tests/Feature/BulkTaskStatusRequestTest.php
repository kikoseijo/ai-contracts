<?php

use Sunnyface\Contracts\Data\Spoke\BulkTaskStatusRequest;

it('strictly returns array of strings from getIdsArray', function () {
    $request = new BulkTaskStatusRequest(' 1, 2 , 3 ');
    
    expect($request->getIdsArray())->toBe(['1', '2', '3']);
});
