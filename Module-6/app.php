<?php

$textStorage = [];

function add(array &$storage, string $title, string $text): void
{
    $storage[] = ['title' => $title, 'text' => $text];
}

add($textStorage, 'New Games', "God of War: Ragnarok, Demon's Souls, Atomic Heart");
add($textStorage, 'New Movies', "The Black Phone, Halloween Ends, Hellraiser");

print_r($textStorage);

function remove(array &$storage, int $textIndex): bool
{
    $is_value_set = isset($storage[$textIndex]);
    if ($is_value_set) {
        array_splice($storage, $textIndex, 1);
    }

    return $is_value_set;
}

var_dump(remove($textStorage, 0));
var_dump(remove($textStorage, 5));
print_r($textStorage);

function edit(int $textIndex, string $titleKey, string $text, array &$storage): bool
{
    $is_text_exist = isset($storage[$textIndex]);
    if ($is_text_exist) {
        $storage[$textIndex][$titleKey] = $text;
    }

    return $is_text_exist;
}

edit(0, 'title', 'Turn Off The Light', $textStorage);
print_r($textStorage);
var_dump(edit(2, 'title', 'Lack Of Imagination', $textStorage));
