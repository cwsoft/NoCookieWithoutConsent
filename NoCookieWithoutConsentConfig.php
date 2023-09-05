<?php

namespace ProcessWire;

/**
 * Class NoCookieWithoutConsentConfig.
 * Module configuration page.
 */
class NoCookieWithoutConsentConfig extends ModuleConfig {
    /**
     * Default module config values.
     * @return Array with default settings.
     */
    public function getDefaults() {
        return array(
            'imprintUrlSegment' => '',
            'privacyPolicyUrlSegment' => ''
        );
    }

    /**
     * Function to create the module configuration page in backend.
     * @return $inputFields
     */
    public function getInputfields() {
        $inputFields = parent::getInputfields();

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'imprintUrlSegment');
        $f->label = $this->_('Imprint URL segment');
        $f->placeholder = $this->_('URL segment to imprint page. Blank if not used.');
        $inputFields->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'privacyPolicyUrlSegment');
        $f->label = $this->_('Privacy policy URL segment');
        $f->placeholder = $this->_('URL segment to privacy policy page. Blank if not used.');
        $inputFields->add($f);

        $f = $this->modules->get('InputfieldSelect');
        $f->attr('name', 'cookieDialogeButtons');
        $f->label = $this->_('Cookie dialoge buttons shown');
        $f->options = array(
            '0' => __('Consent'),
            'consent_decline' => __('Consent+Decline'),
            'consent_close' => __('Consent+Close'),
            'consent_decline_close' => __('Consent+Decline+Close')
        );
        $inputFields->add($f);

        return $inputFields;
    }
}
