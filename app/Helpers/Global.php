<?php

function isMenuActive($currentPageIdentifier, $identifier)
{
    if (is_array($identifier)) {
        return in_array($currentPageIdentifier, $identifier);
    }

    return $currentPageIdentifier == $identifier;
}