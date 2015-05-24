<?php

namespace TextocatSDK;

function Document($text, $tag = '') {
  return ['text' => $text, 'tag' => $tag];
}
