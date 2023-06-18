<?php namespace ProcessWire;
/**
 * Template: cookie-consent-dialogue.php
 * HTML template for the Cookie Consent dialogue.
 */
// Adapt pathes to show imprint and privacy policy pages as link.
$imprintUrl = pages()->findOne('impressum')->url;
$privacyPolicyUrl = pages()->findOne('datenschutz')->url;

// Class to show/hide page links.
$imprintClass = empty($imprintUrl) ? ' class="cc-hidden"' : '';
$privacyPolicyClass = empty($privacyPolicyUrl) ? ' class="cc-hidden"' : '';


$template = "
<section id='cc-wrapper'>
    <h2 class='cc-heading'>" . sprintf(__('Cookie Consent')) . "</h2>
    <p class='cc-text'>
        " . sprintf(__('This site uses required cookies to work properly.')) . "
        " . sprintf(__('Please consent required cookies in order to use all features.')) . "
    </p>

    <div class='cc-buttons'>
        <button id='cc-consent'>" . sprintf(__('Consent')) . "</button>
        <button id='cc-decline'>" . sprintf(__('Decline')) . "</button>
    </div>

    <footer class='cc-footer'>
        <ul>
            <li{$imprintClass}><a href='{$imprintUrl}'>" . sprintf(__('Imprint')) . "</a></li>
            <li{$privacyPolicyClass}><a href='{$privacyPolicyUrl}'>" . sprintf(__('Privacy policy')) . "</a></li>
        </ul>
    </footer>
</section>
";