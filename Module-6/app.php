<?php

$textStorage = [];

function add(array &$storage, string $title, string $text): void
{
    $storage[] = ['title' => $title, 'text' => $text, ];
}

add($textStorage, 'New Games', "God of War: Ragnarok, Demon's Souls, Atomic Heart");
add($textStorage, 'New Movies', "The Black Phone, Halloween Ends, Hellraiser");

print_r($textStorage);

function remove(array &$storage, int $textIndex): bool
{
    $hasText = isset($storage[$textIndex]);
    if ($hasText) {
        array_splice($storage, $textIndex, 1);
    }

    return $hasText;
}

var_dump(remove($textStorage, 0));
var_dump(remove($textStorage, 5));
print_r($textStorage);

function edit(int $textIndex, string $title, string $text, array &$storage): bool
{
    $hasText = isset($storage[$textIndex]);
    if ($hasText) {
        $storage[$textIndex] = ['title' => $title, 'text' => $text, ];
    }

    return $hasText;
}

edit(0, 'Turn Off The Light', $textStorage[0]['text'], $textStorage);
print_r($textStorage);
var_dump(edit(2, 'Lack Of Imagination', 'some people...', $textStorage));
