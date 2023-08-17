<?php

namespace ProcessWire;

/**
 * Template: CookieConsentDialogue.tpl.php.
 * HTML template for the Cookie Consent dialogue.
 */
// Work out if imprint and privacy policy page links should be displayed.
// Url segments can be set in module configuration in the backend.
$imprintUrlSegment = sanitizer()->selectorValue(modules()->get('NoCookieWithoutConsent')->imprintUrlSegment);
$imprintUrl = empty($imprintUrlSegment) ? '' : pages()->findOne($imprintUrlSegment)->url;
$imprintClass = empty($imprintUrl) ? ' class="cc-hidden"' : '';

$privacyPolicySegment = sanitizer()->selectorValue(modules()->get('NoCookieWithoutConsent')->privacyPolicyUrlSegment);
$privacyPolicyUrl = empty($privacyPolicySegment) ? '' : pages()->findOne($privacyPolicySegment)->url;
$privacyPolicyClass = empty($privacyPolicyUrl) ? ' class="cc-hidden"' : '';

// HTML template for the Cookie Consent dialogue.
$template = "
<section id='cc-wrapper' class='cc-hidden'>
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
