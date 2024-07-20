<?php

echo "Example 1\r\n";

for ($i = 1; $i <= 10; $i++) {
    if ($i % 2 == 0) {
        continue;
    }

    echo $i . "\r\n";
}
