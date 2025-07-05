<?php

declare(strict_types=1);

use BezhanSalleh\PluginEssentials\Tests\Fixtures\Models\Post;

test('to array', function () {
    $record = Post::factory()->create()->fresh();

    expect(array_keys($record->toArray()))
        ->toBe([
            'id',
            'title',
            'body',
            'tenant_id',
            'created_at',
            'updated_at',
        ]);
});
