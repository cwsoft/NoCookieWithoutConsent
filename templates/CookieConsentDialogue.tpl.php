<?php

namespace ProcessWire;

/**
 * Template: CookieConsentDialogue.tpl.php.
 * HTML template for the Cookie Consent dialogue.
 */
// Work out if imprint and privacy policy page links should be displayed.
$imprintUrlSegment = sanitizer()->selectorValue(modules()->get('NoCookieWithoutConsent')->imprintUrlSegment);
$imprintUrl = empty($imprintUrlSegment) ? '' : pages()->findOne($imprintUrlSegment)->url;
$imprintClass = empty($imprintUrl) ? ' class="cc-hidden"' : '';

$privacyPolicySegment = sanitizer()->selectorValue(modules()->get('NoCookieWithoutConsent')->privacyPolicyUrlSegment);
$privacyPolicyUrl = empty($privacyPolicySegment) ? '' : pages()->findOne($privacyPolicySegment)->url;
$privacyPolicyClass = empty($privacyPolicyUrl) ? ' class="cc-hidden"' : '';

// Work out cookie dialoge buttons to show.
$dialogeButtons = modules()->get('NoCookieWithoutConsent')->cookieDialogeButtons;
$declineButtonClass = strpos($dialogeButtons, 'decline') > -1 ? '' : ' class="cc-hidden"';
$closeButtonClass = strpos($dialogeButtons, 'close') > -1 ? '' : ' class="cc-hidden"';

// HTML template for the Cookie Consent dialogue.
$template = "
<section id='cc-wrapper' class='cc-hidden'>
    <h2 class='cc-heading'>" . sprintf(__('Cookie Consent')) . "</h2>
    <button id='cc-close-icon'>x</button>
    <p class='cc-text'>
        " . sprintf(__('This site uses required cookies to work properly.')) . "
        " . sprintf(__('Please consent required cookies in order to use all features.')) . "
    </p>

    <div class='cc-buttons'>
        <button id='cc-close'{$closeButtonClass}>" . sprintf(__('Close')) . "</button>
        <button id='cc-decline'{$declineButtonClass}>" . sprintf(__('Decline')) . "</button>
        <button id='cc-consent'>" . sprintf(__('Consent')) . "</button>
    </div>

    <footer class='cc-footer'>
        <ul>
            <li{$imprintClass}><a href='{$imprintUrl}'>" . sprintf(__('Imprint')) . "</a></li>
            <li{$privacyPolicyClass}><a href='{$privacyPolicyUrl}'>" . sprintf(__('Privacy policy')) . "</a></li>
        </ul>
    </footer>
</section>
";
