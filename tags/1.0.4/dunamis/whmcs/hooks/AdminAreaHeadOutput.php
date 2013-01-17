<?php
/**
 * This file outputs document data to the admin head
 */
// $gof = & GoF :: getInstance();
// $doc =   $gof->getDocument();

echo dunloader( 'document', true )->renderHeadData();