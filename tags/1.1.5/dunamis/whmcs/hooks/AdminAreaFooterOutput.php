<?php
/**
 * This file outputs document data to the admin head
 */

echo dunloader( 'document', true )->renderFootData();

echo get_dunamis()->displayErrors();